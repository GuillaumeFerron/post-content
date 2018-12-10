<?php

namespace Guillaumeferron\PostContent;

use Laravel\Nova\Fields\Field;

class PostContent extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'PostContent';

    /**
     * Set the fields to be used when adding a row
     *
     * @param array $fields
     * @return PostContent
     */
    public function withFields(array $fields)
    {
        return $this->withMeta((['fields' => $fields]));
    }

    /**
     * Sets the fields to be used when adding a new carousel slide
     *
     * @param array $carousel_fields
     * @return PostContent
     */
    public function withCarouselFields(array $carousel_fields)
    {
        return $this->withMeta(['carousel_fields' => $carousel_fields]);
    }

    /**
     * Set the file manager url to be used when adding a video or an image
     *
     * @param string $file_manager_url
     * @return PostContent
     */
    public function withFileManager(string $file_manager_url)
    {
        return $this->withMeta(['file_manager_url' => $file_manager_url]);
    }

    /**
     * Hide the helpers
     *
     * @return PostContent
     */
    public function hideHelpers()
    {
        return $this->withMeta(['hide_helpers' => true]);
    }
}
