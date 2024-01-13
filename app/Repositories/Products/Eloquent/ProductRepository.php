<?php

namespace App\Repositories\Products\Eloquent;

use App\Models\Product;
use App\Repositories\Products\Interfaces\ProductInterface;
use App\Repositories\RepositoriesAbstract;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ProductRepository extends RepositoriesAbstract implements ProductInterface
{
    public function getFeatured(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->limit($limit)
            ->with(array_merge(['slugable'], $with))
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getListPostNonInList(array $selected = [], int $limit = 7, array $with = [])
    {
        $data = $this->model
            ->wherePublished()
            ->whereNotIn('id', $selected)
            ->limit($limit)
            ->with($with)
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getRelated($id, int $limit = 3)
    {
        /**
         * @var Post $model
         */
        $model = $this->model;

        $data = $model
            ->wherePublished()
            ->where('id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderByDesc('created_at')
            ->whereHas('categories', function (Builder $query) use ($id) {
                $query->whereIn('categories.id', $this->getRelatedCategoryIds($id));
            });

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getRelatedCategoryIds($model)
    {
        $model = $model instanceof Product ? $model : $this->findById($model);

        if (!$model) {
            return [];
        }

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (Exception) {
            return [];
        }
    }

    public function getByCategory(
        $categoryId,
        int $paginate = 12,
        int $limit = 0
    ) {
        $data = $this->model
            ->wherePublished()
            ->whereHas('categories', function (Builder $query) use ($categoryId) {
                $query->whereIn('categories.id', array_filter((array)$categoryId));
            })
            ->select('*')
            ->distinct()
            ->with('slugable')
            ->orderByDesc('created_at');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    public function getByUserId($authorId, int $paginate = 6)
    {
        $data = $this->model
            ->where([
                'status' => BaseStatusEnum::PUBLISHED,
                'author_id' => $authorId,
            ])
            ->with('slugable')
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->wherePublished()
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getByTag($tag, int $paginate = 12)
    {
        $data = $this->model
            ->with(['slugable', 'categories', 'categories.slugable', 'author'])
            ->wherePublished()
            ->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('tags.id', $tag);
            })
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    public function getRecentPosts(int $limit = 5, $categoryId = 0)
    {
        $data = $this->model->where(['status' => BaseStatusEnum::PUBLISHED]);

        if ($categoryId != 0) {
            $data = $data
                ->whereHas('categories', function (Builder $query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
        }

        $data = $data->limit($limit)
            ->with('slugable')
            ->select('*')
            ->orderByDesc('created_at');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getSearch($keyword,
        int $limit = 10,
        int $paginate = 10
    ) {
        $data = $this->model
            ->with('slugable')
            ->wherePublished()
            ->orderByDesc('created_at');

        $data = $this->search($data, $keyword);

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getAllPosts(
        int $perPage = 12,
        bool $active = true,
        array $with = ['slugable']
    ) {
        $data = $this->model
            ->with($with)
            ->orderByDesc('created_at');

        if ($active) {
            $data = $data->wherePublished();
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    public function getPopularPosts(int $limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderByDesc('views')
            ->wherePublished()
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getFilters(array $filters)
    {
        $data = $this->originalModel;

        if ($filters['categories'] !== null) {
            $categories = array_filter((array)$filters['categories']);

            $data = $data->whereHas('categories', function (Builder $query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        if ($filters['categories_exclude'] !== null) {
            $data = $data
                ->whereHas('categories', function (Builder $query) use ($filters) {
                    $query->whereNotIn('categories.id', array_filter((array)$filters['categories_exclude']));
                });
        }

        if ($filters['exclude'] !== null) {
            $data = $data->whereNotIn('id', array_filter((array)$filters['exclude']));
        }

        if ($filters['include'] !== null) {
            $data = $data->whereNotIn('id', array_filter((array)$filters['include']));
        }

        if ($filters['author'] !== null) {
            $data = $data->whereIn('author_id', array_filter((array)$filters['author']));
        }

        if ($filters['author_exclude'] !== null) {
            $data = $data->whereNotIn('author_id', array_filter((array)$filters['author_exclude']));
        }

        if ($filters['featured'] !== null) {
            $data = $data->where('is_featured', $filters['featured']);
        }

        if ($filters['search'] !== null) {
            $data = $this->search($data, $filters['search']);
        }

        $orderBy = Arr::get($filters, 'order_by', 'updated_at');
        $order = Arr::get($filters, 'order', 'desc');

        $data = $data
            ->wherePublished()
            ->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($data)->paginate((int)$filters['per_page']);
    }

    protected function search(Builder $model, string|null $keyword): Builder
    {
        if (!$model instanceof Builder || !$keyword) {
            return $model;
        }

        if (
            is_plugin_active('language') &&
            is_plugin_active('language-advanced') &&
            Language::getCurrentLocale() != Language::getDefaultLocale()
        ) {
            return $model
                ->whereHas('translations', function (Builder $query) use ($keyword) {
                    $query
                        ->addSearch('name', $keyword, false, false)
                        ->addSearch('description', $keyword, false);
                });
        }

        return $model
            ->where(function (Builder $query) use ($keyword) {
                $query
                    ->addSearch('name', $keyword, false, false)
                    ->addSearch('description', $keyword, false);
            });
    }
}
