<?php

namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;


trait DesignationableEntity
{


    /**
     * @ORM\Column(name="label", type="string", length=128)
     */
    protected $label;

    /**
     * @ORM\Column(name="slug", type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"label"})
     */
    protected $slug;

    /**
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * Set label
     *
     * @param string $label
     * @return instance
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }


}
