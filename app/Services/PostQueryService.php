<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostQueryService
{
    protected $query;
    protected $defaults = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'paged' => 1,
    ];

    public function __construct()
    {
        $this->query = Post::query();
    }

    /**
     * Run the query with given parameters, WordPress-style.
     *
     * @param array $args The chaotic mess of filters you’d throw at WP_Query
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(array $args = [])
    {
        $params = array_merge($this->defaults, $args);

        $this->applyPostType($params['post_type'])
             ->applyPostStatus($params['post_status'])
             ->applyMetaQuery($params['meta_query'] ?? [])
             ->applyTaxQuery($params['tax_query'] ?? [])
             ->applyPagination($params['posts_per_page'], $params['paged']);

        return $this->query->paginate($params['posts_per_page']);
    }

    /**
     * Filter by post type, because WordPress loves its custom types.
     */
    protected function applyPostType(string|array $postType): self
    {
        if (is_array($postType)) {
            $this->query->whereIn('post_type', $postType);
        } else {
            $this->query->where('post_type', $postType);
        }
        return $this;
    }

    /**
     * Filter by status, because drafts are a thing.
     */
    protected function applyPostStatus(string|array $postStatus): self
    {
        if (is_array($postStatus)) {
            $this->query->whereIn('post_status', $postStatus);
        } else {
            $this->query->where('post_status', $postStatus);
        }
        return $this;
    }

    /**
     * Pagination, because infinite scrolls are overrated.
     */
    protected function applyPagination(int $perPage, int $page): self
    {
        $this->query->forPage($page, $perPage);
        return $this;
    }

    protected function applyMetaQuery(array $metaQuery): self
    {
        if (empty($metaQuery)) {
            return $this;
        }

        $relation = $metaQuery['relation'] ?? 'AND';
        unset($metaQuery['relation']);

        $this->query->where(function ($query) use ($metaQuery, $relation) {
            foreach ($metaQuery as $meta) {
                $key = $meta['key'] ?? '';
                $value = $meta['value'] ?? '';
                $compare = $meta['compare'] ?? '=';

                if (!$key) {
                    continue;
                }

                $method = $relation === 'OR' ? 'orWhereHas' : 'whereHas';
                $query->$method('meta', function (Builder $q) use ($key, $value, $compare) {
                    $q->where('meta_key', $key)->where('meta_value', $compare, $value);
                });
            }
        });

        return $this;
    }

    protected function applyTaxQuery(array $taxQuery): self
    {
        if (empty($taxQuery)) {
            return $this;
        }

        $relation = $taxQuery['relation'] ?? 'AND';
        unset($taxQuery['relation']);

        $this->query->where(function ($query) use ($taxQuery, $relation) {
            foreach ($taxQuery as $tax) {
                $taxonomy = $tax['taxonomy'] ?? '';
                $field = $tax['field'] ?? 'term_id';
                $terms = $tax['terms'] ?? [];
                $operator = $tax['operator'] ?? 'IN';

                if (!$taxonomy || empty($terms)) {
                    continue;
                }

                $method = $relation === 'OR' ? 'orWhereHas' : 'whereHas';
                $query->$method('taxonomies', function (Builder $q) use ($taxonomy, $field, $terms, $operator) {
                    $q->where('taxonomy', $taxonomy);

                    if (!is_array($terms)) {
                        $terms = [$terms];
                    }

                    $column = match ($field) {
                        'slug' => 'term.slug',
                        'name' => 'term.name',
                        default => 'term_taxonomy.term_id',
                    };

                    if ($operator === 'NOT IN') {
                        $q->whereHas('term', fn ($q) => $q->whereNotIn($column, $terms));
                    } elseif ($operator === 'AND') {
                        foreach ($terms as $term) {
                            $q->whereHas('term', fn ($q) => $q->where($column, $term));
                        }
                    } else {
                        $q->whereHas('term', fn ($q) => $q->whereIn($column, $terms));
                    }
                });
            }
        });

        return $this;
    }

    /**
     * Get the raw query builder if you’re feeling adventurous.
     */
    public function query(): Builder
    {
        return $this->query;
    }
}