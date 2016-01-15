<?php
	namespace Uneak\ImportBundle\Reader;

	use Ddeboer\DataImport\Reader\CountableReaderInterface;

	class CsvReader extends \ArrayIterator implements CountableReaderInterface
	{

		/**
		 * Column headers as read from the CSV
		 *
		 * @var array
		 */
		protected $columnHeaders = null;



		public function __construct($csv, $rowDelimiter = ',', $delimiter = ',', $enclosure = '"', $escape = '\\')
		{
			$encoding = mb_detect_encoding($csv);
			if ($encoding != 'UTF-8') {
				$csv = mb_convert_encoding($csv, 'UTF-8');
			}
			$CR = "\r";          // Carriage Return: Mac
			$LF = "\n";          // Line Feed: Unix
			$CRLF = "\r\n";      // Carriage Return and Line Feed: Windows

			$csv = str_replace($CRLF, $LF, $csv);
			$csv = str_replace($CR, $LF, $csv);
			// Don't allow out-of-control blank lines
			$csv = preg_replace("/\n{2,}/", $LF . $LF, $csv);
			$csv = utf8_encode($csv);



			$rows = array_filter(explode($LF, $csv));
			$data = array();
			foreach($rows as $row) {

				if(!$this->columnHeaders) {
					$row = str_getcsv($row, $rowDelimiter, $enclosure , $escape);
					$this->setColumnHeaders($row);

				} else {
					$row = str_getcsv($row, $delimiter, $enclosure , $escape);
					$data[] = $row;
				}

			}

			parent::__construct($data);
		}


		/**
		 * Get column headers
		 *
		 * @return array
		 */
		public function getColumnHeaders()
		{
			return $this->columnHeaders;
		}

		/**
		 * Set column headers
		 *
		 * @param array $columnHeaders
		 *
		 * @return CsvReader
		 */
		public function setColumnHeaders(array $columnHeaders)
		{
			$this->columnHeaders = $columnHeaders;
			return $this;
		}





		/**
		 * {@inheritdoc}
		 */
		public function getFields()
		{
			// Examine first row
			if ($this->count() > 0) {
				return \array_keys($this[0]);
			}

			return array();
		}
	}
