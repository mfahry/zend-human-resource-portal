<?php
class Pencarian extends Controller {

 function Pencarian()
 {
  parent::Controller(); 
 }
 
 function index()
 { 
        /*ambil parameter kunci yg dikirim dari plugin jquery autocomplete tadi*/
  $q = $this->input->post('q');  
        
        /*
        untuk keperluan tutorial ini list data item ini langsung dideklarasikan dalam bentuk array,
        cuman biasanya dalam prakteknya nanti biasanya list item ini akan di query / dihasilkan dari database aplikasi
        */
  $items = array(
   "Great Bittern" => "Botaurus stellaris",
   "Little Grebe" => "Tachybaptus ruficollis",
   "Black-necked Grebe" => "Podiceps nigricollis",
   "Little Bittern" => "Ixobrychus minutus",
   "Black-crowned Night Heron" => "Nycticorax nycticorax",
   /*
                ....
                ....
                ....
                list item yg akan dikembalikan
                ....
                ....
                ....
            */
   "Madeira Little Shearwater" => "Puffinus baroli",
   "House Finch" => "Carpodacus mexicanus",
   "Green Heron" => "Butorides virescens",
   "Solitary Sandpiper" => "Tringa solitaria",
   "Heuglin's Gull" => "Larus heuglini"
  );
        
        /*parsing data kembalian dan keluarkan item yang sesuai dengan kata kunci*/
  foreach ($items as $key => $value) {
   if (strpos(strtolower($key), $q) !== false) {
    echo "$key|$valuen";
   }
  }
 }
}
?>