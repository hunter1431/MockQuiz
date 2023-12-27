namespace App\Services;

use Illuminate\Support\Facades\File;

class InfoPathBridge
{
   private $datFile = 'SetUp.dat';

   public function infopath()
   {
       $fileName = base_path($this->datFile);
       $strInput = '';

       try {
           $strInput = File::get($fileName);
       } catch (\Exception $ex) {
           $strInput = $ex->getMessage();
       }

       return $strInput;
   }

   public function getInfoPath()
   {
       $strInfoPath = $this->infopath();
       $parsed = explode("|", $strInfoPath);

       $mssql = new MSSQL;
       $mssql->database = $parsed[0];
       $mssql->datasource = $parsed[1];
       $mssql->UID = $parsed[2];
       $mssql->Pword = $parsed[3];

       return $mssql;
   }
}
