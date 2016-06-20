<?php
	class Library{
		private $bookName;
		static $books = array();

		 /* Keeps track of the books supplied
		 *
		 * @access public supplyBook
		 * @param 
		 * @return array books
		 */
		function supplyBook(){
			$bookName = $bookObj->Borrower::getBook();
			array_push($books, this->$bookName);
			return $books;
		}

	}
	class Borrower{
		private $bookNeed;

		/* Constructor, initialize field variable
		 *
		 * @access public
		 * @param string require
		 * @return
		 */
		function __construct($require){
			this->bookNeed = $require;
		}

		/* getBook()
		 *
		 * @access public
		 * @param 
		 * @return string bookNeed
		 */
		function getBook(){
			return $bookNeed;
		}
	}
	$bookObj = new Borrower('philosophy');
	$bookList = $bookObj->Library::supplyBook();
?>