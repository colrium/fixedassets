<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class Csvimport {

	private $filepath = "";
    private $handle = "";
    private $column_headers = "";
    private $dbfile = FALSE;
   /**
     * Function that parses a CSV file and returns results
     * as an array.
     *
     * @access  public
     * @param   filepath        string  Location of the CSV file
     * @param   column_headers  array   Alternate values that will be used for array keys instead of first line of CSV
     * @param   detect_line_endings  boolean  When true sets the php INI settings to allow script to detect line endings. Needed for CSV files created on Macs.
     * @return  array
     */
    public function get_array($filepath='', $column_headers='', $usedbfile = TRUE, $detect_line_endings=FALSE){
        // If true, auto detect row endings
        if($detect_line_endings){
            ini_set("auto_detect_line_endings", TRUE);
        }

        if ($usedbfile == TRUE) {
            $this->dbfile = TRUE;
            $this->_set_filepath($filepath);
        }
        else{
            // If file exists, set filepath
            if(file_exists($filepath)){
                $this->_set_filepath($filepath);
            }
            else{
                return FALSE;            
            }
        }

        // If column headers provided, set them
        $this->_set_column_headers($column_headers);

        // Open the CSV for reading
        $this->_get_handle();
        
        $row = 0;

        while (($data = fgetcsv($this->handle, 0, ",")) !== FALSE) 
        {   
            // If first row, parse for column_headers
            if($row == 0)
            {
                // If column_headers already provided, use them
                if($this->column_headers){
                    foreach ($this->column_headers as $key => $value)
                    {
                        $column_headers[$key] = trim($value);
                    }
                }
                else // Parse first row for column_headers to use
                {
                    foreach ($data as $key => $value)
                    {
                        $column_headers[$key] = trim($value);
                    }                
                }          
            }
            else
            {
                $new_row = $row - 1; // needed so that the returned array starts at 0 instead of 1
                foreach($column_headers as $key => $value){
                    if (strlen($key)>0) {
                        $celldata = trim($data[$key]);
                        if (strlen($celldata)==0) {
                            $celldata = '';
                        }
                        $result[$new_row][$value] = $celldata;
                    }
                        
                }
            }
            $row++;
        }
 
        $this->_close_csv();

        return $result;
    }

    public function get_totalrows($filepath='', $usedbfile = TRUE, $detect_line_endings=FALSE){
        // If true, auto detect row endings
        if($detect_line_endings){
            ini_set("auto_detect_line_endings", TRUE);
        }
        if ($usedbfile == TRUE) {
            $this->dbfile = TRUE;
            $this->_set_filepath($filepath);
        }
        else{
            // If file exists, set filepath
            if(file_exists($filepath)){
                $this->_set_filepath($filepath);
            }
            else{
                return FALSE;            
            }
        }
            


        // Open the CSV for reading
        $this->_get_handle();
        
        $row = 0;

        while (($data = fgetcsv($this->handle, 0, ",")) !== FALSE){                       
            $row++;
        }
 
        $this->_close_csv();

        return $row-1;
    }



    public function get_samplerows($filepath=''){
        $total = $this->get_totalrows($filepath);
        $sampleSize = 10;
        $sampleData = array();
        $sampleData = array();
        if ($total > 10) {
            $sampleSize = floor(0.1*$total);
        }
        else{
            $sampleSize = $total;
        }
        for ($i=1; $i < $sampleSize; $i++) { 

            array_push($sampleData, $this->get_row($filepath, $i));
        }

        return $sampleData;
    }


    public function get_row($file_path="", $key=""){ 
        $rowcells = $this->get_array($file_path);
        $rowdata = array();
        $csv_headers =  $this->get_column_headers($file_path);
        $rowcells = $rowcells[$key];
        foreach ($csv_headers as $key => $value) {
            $rowdata[$value] = $rowcells[$value];
        }

        return $rowdata;    
    }

    public function get_column_headers($filepath='', $column_headers='', $usedbfile = TRUE, $detect_line_endings=FALSE)
    {
        // If true, auto detect row endings
        if($detect_line_endings){
            ini_set("auto_detect_line_endings", TRUE);
        }
        if ($usedbfile == TRUE) {
            $this->dbfile = TRUE;
            $this->_set_filepath($filepath);
        }
        else{
            // If file exists, set filepath
            if(file_exists($filepath)){
                $this->_set_filepath($filepath);
            }
            else{
                return FALSE;            
            }
        }
        

       
        // Open the CSV for reading
        $this->_get_handle();
        
        $row = 0;

        while (($data = fgetcsv($this->handle, 0, ",")) !== FALSE) 
        {   
            // If first row, parse for column_headers
            if($row == 0)
            {
               // Parse first row for column_headers to use
                
                    foreach ($data as $key => $value)
                    {
                        $column_headers[$key] = trim($value);
                    }                
                          
            }
            else{

            }

           $row++; 
        }
 
        $this->_close_csv();

        return $column_headers;
    }

   /**
     * Sets the filepath of a given CSV file
     *
     * @access  private
     * @param   filepath    string  Location of the CSV file
     * @return  void
     */
    private function _set_filepath($filepath){
        $this->filepath = $filepath;
        
    }

   /**
     * Sets the alternate column headers that will be used when creating the array
     *
     * @access  private
     * @param   column_headers  array   Alternate column_headers that will be used instead of first line of CSV
     * @return  void
     */
    private function _set_column_headers($column_headers='')
    {
        if(is_array($column_headers) && !empty($column_headers))
        {
            $this->column_headers = $column_headers;
        }
    }

   /**
     * Opens the CSV file for parsing
     *
     * @access  private
     * @return  void
     */
    private function _get_handle(){
        if ($this->dbfile) {
            $attachment = dbtablerecord($this->filepath, 'attachments');

            $this->handle = fopen('data://text/plain;base64,'.$attachment->file, 'r');
        }
        else{
            $this->handle = fopen($this->filepath, "r");
        }
        
            
  
        
    }

   /**
     * Closes the CSV file when complete
     *
     * @access  private
     * @return  array
     */
    private function _close_csv(){
        fclose($this->handle);
    }    
}