<?php

	namespace Uneak\TemplatesManagerBundle\Templates;

    use Symfony\Component\DependencyInjection\ContainerInterface;

	class TemplatesManager {

        protected $templates = array();

        public function __construct($configTemplates) {
            foreach ($configTemplates as $id => $template) {
                $this->set($id, $template, true);
            }
        }

        public function getTemplates() {
            return $this->templates;
        }

        public function getTemplate($id) {
            if (!isset($this->templates[$id])) {
                // TODO lever une exeption
            }
            return $this->templates[$id];
        }

        public function setTemplate($id, $template, $override = true) {
            if ($override || !isset($this->templates[$id])) {
                $this->templates[$id] = $template;
            }

            return $this;
        }

        public function hasTemplate($id) {
            return isset($this->templates[$id]);
        }

        public function removeTemplate($id) {
            unset($this->templates[$id]);
            return $this;
        }


    }
