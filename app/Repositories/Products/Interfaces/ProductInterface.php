<?php

namespace App\Repositories\Products\Interfaces;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductInterface extends RepositoryInterface
{
    public function getFeatured(int $limit = 5, array $with = []);

    public function getListPostNonInList(array $selected = [], int $limit = 7, array $with = []);

    public function getRelated($id, int $limit = 3);

    public function getRelatedCategoryIds($model);

    public function getByCategory( $categoryId, int $paginate = 12, int $limit = 0);

    public function getByUserId($authorId, int $paginate = 6);

    public function getDataSiteMap();

    public function getByTag($tag, int $paginate = 12);

    public function getRecentPosts(int $limit = 5, $categoryId = 0);

    public function getSearch($keyword, int $limit, int $paginate);

    public function getAllPosts(int $perPage = 12, bool $active = true, array $with = ['slugable']);

    public function getPopularPosts(int $limit, array $args = []);

    public function getFilters(array $filters);
}
