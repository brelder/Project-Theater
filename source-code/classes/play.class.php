<?php 

class Play extends PortalesDB{

    //Method that adds play information to the table
    protected function insertPlay($playTitle, $shortDesc, $longDesc, $sDate, $eDate){
        $query = 'INSERT INTO plays (play_title, long_desc, short_desc, stime, etime) VALUES (?,?,?,?,?);';
        $statement = $this->connect()->prepare($query);


        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array($playTitle, $shortDesc, $longDesc, $sDate, $eDate))){
            $statement = null;
            header("location: ../management/index.php?error=errorAddPlay");
            exit();
        }
        $statement = null;
    }

    //Method that uploads the image
    protected function uploadImage($path,$base64){
        $query = 'SELECT * FROM latestplay;';
        $statement = $this->connect()->prepare($query);
        
     
        //this checks if the query is executed sucesfully 
        if(!$statement->execute(array())){
            $statement = null;
            header("location: ../management/index.php?error=errorUploadImage");
            exit();
        }  


        //Check if rows
        if($statement->rowCount()==0){
            $statement = null;
            session_start();
            $_SESSION["message"] = "Error: The e-mail you’ve entered doesn't exist.";
            header("location: ../management/index.php?error=errorUploadImage");
            exit();          
        }

        $play = $statement->fetchAll(PDO::FETCH_ASSOC); //fetch all the play data
        $imageName = $play[0]["play_id"];
        $file = $path . $imageName . '.png';
        file_put_contents($file, "$base64");
        $statement = null;

    }

}
