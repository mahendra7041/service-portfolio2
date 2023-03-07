<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database class</title>
</head>
<body>
    <pre>
    <?php
        include "DB.php";

        // // inserting data 
        // //return true or false
        // DB::table('user')->insert([
        //     'username' => 'chavda',
        //     'password' => '12345678',
        // ])->isInsert();

        // //get inserted id
        // DB::table('user')->insert([
        //     'username' => 'chavda',
        //     'password' => '12345678',
        // ])->getInsertedId();

        // //update
        // DB::table('user')->update([
        //     'username' => 'chavda',
        //     'password' => '12345678',
        // ])->where('id = ?');

        // //delete
        // DB::table('user')->delete('?');

        // //fetching all record
        // DB::table('user')->all();
        
        // //fetching record whith condtion
        // DB::table('user')->where('id = ?')->get();
        // //or for id only
        // DB::table('user')->find('?');

        // //fetching limited record
        // DB::table('user')->limit(10)->get();

        // //select column
        // DB::table('user')->select('id, name, usename')->get();

        // //fetch first record
        // DB::table('user')->first();
        
        // //fetch last record
        // DB::table('user')->last();

        // //order by
        // DB::table('user')->orderby('id DESC')->get();

        // // fetching data with conditon 
        // DB::table('user')->where('column = ?')->get();

        // // store file
        // //returning storage path in server
        // DB::table('user')->file($_FILES['filename'])->store('path');

        // // record fetching with join 
        // DB::table('user')->join('table2','table1.col','table2.col')->get();
        // DB::table('user')->innerJoin('table2','table1.col','table2.col')->get();
        // DB::table('user')->leftJoin('table2','table1.col','table2.col')->get();
        // DB::table('user')->rightJoin('table2','table1.col','table2.col')->get();

        // print_r($data);

        // $rows = DB::table('user')->where("id = 25")->update(['username' => 'mahi','password'=>'mahi1234']);
        // $rows = DB::table('user')->file($_FILES['image'])->store('images');
        // $rows = DB::table('user')->select('user.id,user.username,category.name')->join('category','user.id','category.user_id')->where('user.id = 25')->get();
        // $rows = DB::table('user')->join('category','user.id','category.user_id')->get();


        // print_r($rows);
        
    ?>
    <h1>db class</h1>
</body>
</html>