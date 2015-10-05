<?php

	namespace AppBundle\VichUploader\Naming;


	use Doctrine\ORM\EntityManagerInterface;
    use Vich\UploaderBundle\Mapping\PropertyMapping;
    use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

    class DirectoryNamer implements DirectoryNamerInterface {


        /**
         * @var \Doctrine\ORM\EntityManagerInterface
         */
        private $em;

        public function __construct(EntityManagerInterface $em) {
            $this->em = $em;
        }
        /**
         * Creates a directory name for the file being uploaded.
         *
         * @param object          $object  The object the upload is attached to.
         * @param Propertymapping $mapping The mapping to use to manipulate the given object.
         *
         * @return string The directory name.
         */
        public function directoryName($object, PropertyMapping $mapping) {
            $r = new \ReflectionObject($object);
            return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $this->em->getClassMetadata($r->getName())->getTableName()));
        }

    }
