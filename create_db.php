class Table{
    public $table_name;
    public $no_of_columns;
    public $column_name;
    public $column_type;
    public $size;
    public $constrains;
    public $columns;
    public $mysqli_connection;

    /**
     * Table constructor.
     * @param $mysqli_connection mysqli connection variable
     * @example    $conn= new mysqli($mysqli_host,$mysqli_username,$mysqli_password);
     * $table= new Table($conn);
     */

    function __construct($mysqli_connection){
        $this->mysqli_connection=$mysqli_connection;
    }

    /**
     * @param string $table_name give the name of the Table
     * @return string
     */

    function setTable_name($table_name){
        $this->table_name=$table_name;
        return $table_name;
    }

    /**
     * @param string $column_name give the name of the field
     * @param string $column_type give type of field
     * @param int $size give the size based on the column type of field
     * @example if the column has to size, enter ("") with out brackets
     * @param string $constrains state the various constrains (can be more than one)
     * @return string $this return the string of the field
     * @uses  create as many methods based on the number of fields or columns
     * each method (setcolumn(args)) is a field or column
     */

    function setColumn( $column_name ,$column_type,$size,$constrains){
        $this->column_name=$column_name;
        $this->column_type=strtoupper($column_type);
        $this->size= $size;
        $this->constrains=strtoupper($constrains);
        $this->get_columns();
        return $column_name;
    }

    /**
     * validate int $size  if a string is entered  equate it to 70
     * @return string $this->columns returns the string of the various fields or columns created by concatenating each method created
     */
    function get_columns()
    {
        if(!filter_var($this->size, FILTER_VALIDATE_INT) === true && !empty($this->size)){
            $this->size=50;
        }
        if(empty($this->size)){
            $this->columns.="$this->column_name $this->column_type $this->size $this->constrains,";
        }else{
            $this->columns.="$this->column_name $this->column_type ($this->size) $this->constrains,";
        }
        return $this->columns;
    }

    /**
     * @return bool checks if table exits
     */
    function table_exist(){
        $conn=$this->mysqli_connection;
        $table_name=$this->table_name;
        $sql="SELECT * FROM $table_name";
        if($conn->query($sql)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * @return bool|mysqli_result creates table
     */
    function create_table(){
        $conn=$this->mysqli_connection;
        $sql="CREATE TABLE $this->table_name(id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
        $sql.="$this->columns";
        $sql.="date_time TIMESTAMP NOT NULL)";
        if($this->table_exist()==FALSE){
            $table=$conn->prepare("$sql");
            return $table->execute();
        }else{
            return FALSE;
        }
    }

    /**
     * @param string $column_name state the column name
     * @param string $type_constrain state type,type value and the constrains
     * @example alter_table ("table_name","column_name","varchar (10) not null unsigned  ");
     * @return bool|mysqli_result
     */
    function alter_table($column_name,$type_constrain){
        $table_name=$this->table_name;
        $conn=$this->mysqli_connection;
        $type_constrain=strtoupper($type_constrain);
        $sql="SELECT $column_name FROM $table_name";
        if($conn->query("$sql")==FALSE){
            $sql="ALTER TABLE $table_name ADD $column_name $type_constrain";
            return $conn->query($sql);
        }
        return false;
    }
}
