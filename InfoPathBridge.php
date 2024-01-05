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

       $mysql = new MSSQL;
       $mysql->database = $parsed[0];
       $mysql->datasource = $parsed[1];
       $mysql->UID = $parsed[2];
       $mysql->Pword = $parsed[3];

       return $mysql;
   }
}
