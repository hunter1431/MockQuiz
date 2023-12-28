namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class MSSQLService
{
 
private $infoPathBridge;

public function __construct()
{
   $this->infoPathBridge = new InfoPathBridge();
}


 public function execQuery($query, $tableName) {
     $results = DB::select($query);
     return collect($results)->toArray();
 }

 public function execStoredProc($storedProc, $tableName, $params = null) {
     $query = "EXECUTE " . $storedProc;

     if ($params !== null) {
         foreach ($params as $param) {
             $query .= " " . $param;
         }
     }

     return $this->execQuery($query, $tableName);
 }

 public function execScalarObj($query) {
     $result = DB::selectOne($query);
     return $result !== null ? get_object_vars($result)[0] : null;
 }

 public function execScalar($query) {
     $result = DB::selectOne($query);
     return $result !== null ? get_object_vars($result)[0] : null;
 }

 public function execNonQuery($query) {
     $affectedRows = DB::statement($query);
     return $affectedRows;
 }

public function connectDB()
{
   $mssql = $this->infoPathBridge->getInfoPath();

   $dsn = "sqlsrv:Server={$mssql->datasource};Database={$mssql->database}";
   $conn = new PDO($dsn, $mssql->UID, $mssql->Pword);

   return $conn;
}

}
