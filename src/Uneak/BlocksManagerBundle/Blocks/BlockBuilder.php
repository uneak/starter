<?php

	namespace Uneak\BlocksManagerBundle\Blocks;

    use Uneak\AssetsManagerBundle\Assets\AssetsBuilderManager;
    use Uneak\AssetsManagerBundle\Assets\AssetsBuilder;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Uneak\TemplatesManagerBundle\Templates\TemplatesManager;

    class BlockBuilder extends AssetsBuilder {

        protected $templatesManager;
        protected $blockTemplatesManager;
        protected $blocksManager;
        protected $container;
        protected $blocks = array();
        protected $templateBuildCount = 0;


        public function __construct(TemplatesManager $templatesManager,BlocksManager $blocksManager, BlockTemplatesManager $blockTemplatesManager, ContainerInterface $container) {
            $this->templatesManager = $templatesManager;
            $this->blockTemplatesManager = $blockTemplatesManager;
            $this->container = $container;
            $this->blocksManager = $blocksManager;
        }


        public function debug() {
            $str = "";
            $str .= "<ul>";
            foreach ($this->blocks as $id => $block) {
                $str .= "<li>";
                $str .= $id;
                if (!is_string($block)) {
                    $str .= $block->debug();
                } else {
                    $str .= ":".$block.":";
                }
                $str .= "</li>";
            }
            $str .= "</ul>";

            return $str;
        }

        public function addBlock($id, $block, $override = true) {
            if ($override || !isset($this->blocks[$id])) {
                $this->blocks[$id] = $block;
            }
            return $this;
        }

        public function setBlocks(array $blocks) {
            $this->blocks = $blocks;
            return $this;
        }

        public function getBlocks() {
            foreach ($this->blocks as $id => $block) {
                $this->_blockResolver($this->blocks[$id]);
            }
            return $this->blocks;
        }

        public function getBlock($id) {
            preg_match("/([^\\/]*)(?:\\/(.*))?$/", $id, $matches);
            $id = $matches[1];
            $path = (isset($matches[2])) ? $matches[2] : null;

            if (!isset($this->blocks[$id])) {
                // TODO: exeption
                return null;
            }

            $this->_blockResolver($this->blocks[$id]);


            if ($path) {
                $block = $this->_getPath($this->blocks[$id], $path);
            }

            return $this->blocks[$id];

        }

        private function _getPath(BlockInterface $block, $path) {
            preg_match("/([^\\/]*)(?:\\/(.*))?$/", $path, $matches);
            $id = $matches[1];
            $path = (isset($matches[2])) ? $matches[2] : null;

            if (null === $childBlock = $block->getBlock($id)) {
                // TODO: exeption
                return null;
            }

            if ($path) {
                return $this->_getPath($childBlock, $path);
            } else {
                return $childBlock;
            }
        }

        public function hasBlock($id) {
            return isset($this->blocks[$id]);
        }

        public function removeBlock($id) {
            unset($this->blocks[$id]);
            return $this;
        }



        public function renderResponse($id, array $parameters = array(), Response $response = null) {
            return $this->container->get('templating')->renderResponse('{{ renderBlock("'.$id.'") }}', $parameters, $response);
        }

        public function render($id, array $parameters = array()) {
            return $this->container->get('templating')->render('{{ renderBlock("'.$id.'") }}', $parameters);
        }


        //
        //


        public function processBuildAssets(AssetsBuilderManager $builder) {

            $this->templateBuildCount = 0;

            $blocks = $this->getBlocks();
            foreach ($blocks as $block) {
                $this->_fetchAssets($builder, $block);
            }

        }

        private function _fetchAssets(AssetsBuilderManager $builder, BlockInterface $block) {
            if ($block->isTemplateDirty()) {
                $blockTemplate = $this->blockTemplatesManager->getTemplate($block->getTemplateAlias());

                if (null !== $blockTemplate) {
                    $blockTemplate->buildAsset($builder, $block);
                }

                $this->templateBuildCount++;

                $block->setTemplateDirty(false);
            }

            $blocks = $block->getBlocks();
            foreach ($blocks as $block) {
                $this->_fetchAssets($builder, $block);
            }
        }



        private function _blockResolver(&$block) {
            if (is_string($block)) {
                $block = $this->blocksManager->getBlock($block);
            }
            if (!$block instanceof Block) {
                // TODO: exeption
            }

            $block->processBuildBlocks($this->blocksManager);

        }

    }
