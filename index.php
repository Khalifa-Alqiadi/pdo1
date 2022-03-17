<?php
    include "header.php";
    include "db.php";
    // $database = new Database();
    $db = DB::getInstance();
    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';


    if($do == 'Manage'){
        // echo $db->getSQL();
        
        $query = $db->table('items')->select("categories.ID", "items.*")
        ->join("categories", "categories.ID", "items.cat_id")
        ->get();

        print_r($query);

            // $user = $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
        // $where = $database->where("ItemID", "=", "6");
        // $rows = $database->getAllTable("*", "items", $where, '', "ItemID", ""); ?>
        <h1 class="text-center">All Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table manage-members text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Images</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Date</td>
                        <td>Control</td>
                    </tr>
                    <?php

                        foreach($query as $row){

                            echo "<tr>" .
                                    "<td>" . $row['ID'] . 
                                    "</td><td class='avatar-img'>";
                                    echo "<img src='upload/images/" . $row['image'] ."' alt=''>";
                                    echo "</td><td>" . $row['Name'] . 
                                    "</td><td>" . $row['Description'] . 
                                    "</td><td>" . $row['Date'] . 
                                    "</td><td>
                                    <a href='index.php?do=Edit&itemid=" . $row['ItemID'] . "' 
                                        class='btn btn-success'>
                                        <i class='fa fa-edit'></i> Edit</a>
                                    <a href='index.php?do=Delete&itemid=" . $row['ItemID'] . "' 
                                        class='btn btn-danger confirm'>
                                        <i class='fa fa-close'></i> Delete</a>"; 
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <a href="index.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
        </div>
<?php }elseif($do == 'Add'){ ?>

        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <div class="form-container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- Start Name -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Enter Item Name">
                        </div>
                    </div>
                    <!-- End Name -->
                    <!-- Start Description -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="descrip" class="form-control" required="required" placeholder="Enter Description">
                        </div>
                    </div>
                    <!-- End Description -->
                    <!-- Start Price -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text" name="price" class="form-control" placeholder="Enter Price Item">
                            <i class="show-pass fa fa-eye fa-1x"></i>
                        </div>
                    </div>
                    <!-- End Price -->
                    <!-- Start Quentity -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Quentity</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="number" name="quentity" class="form-control" placeholder=" Enter quentity item">
                        </div>
                    </div>
                    <!-- End Quentity -->
                    <!-- Start Categories Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="category">
                                <option value="0">...</option>
                                <?php
                                    $allCats = $db->table("categories")->get();
                                    foreach($allCats as $cat){
                                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start Image Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10 col-md-9">
                            <input type="file" name="image" class="form-control" required="required">
                        </div>
                    </div>
                    <!-- End Image Field -->
                    <!-- Start Submit -->
                    <div class="mb-2 row">
                        <div class="offset-sm-2 col-sm-10">
                            <input type="submit" value="Add Member" class=" btn btn-primary ">
                        </div>
                    </div>
                    <!-- End Submit -->
                </form>
            </div>
        </div> 

<?php }elseif($do == 'Insert'){ 

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo "<h1 class='text-center'>Insert Item</h1>";
            echo "<div class='container'>";            
            $imageName = $_FILES['image']['name'];
            $imageType = $_FILES['image']['type'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp  = $_FILES['image']['tmp_name'];

            $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");

            @$imageExtension = strtolower(end(explode('.', $imageName)));

            $name = $_POST['name'];
            $descrip = $_POST['descrip'];
            $price = $_POST['price'];
            $quentity = $_POST['quentity'];
            $category = $_POST['category'];

            $formArray = array();
            if(empty($name)){
                $formArray[] = 'Item name Cant Be <strong>Empty</strong>';
            }
            if(empty($descrip)){
                $formArray[] = 'Description item Cant Be <strong>Empty</strong>';
            }
            if(empty($price)){
                $formArray[] = 'Price Item Cant Be <strong>Empty</strong>';
            }
            if(empty($quentity)){
                $formArray[] = 'Quentity Item Cant Be <strong>Empty</strong>';
            }
            if(empty($category)){
                $formArray[] = 'Category Item Cant Be <strong>Empty</strong>';
            }
            if(! empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension)){
                $formArray[] = 'This Extension Is Not <strong>Allowed</strong>';
            }
            if(empty($imageName)){
                $formArray[] = 'Image Is <strong>Required</strong>';
            }
            if($imageSize > 4194304){
                $formArray[] = 'Image Cant Be Larger Than <strong>4MB</strong>';
            }
            foreach($formArray as $errors){
                echo '<div class="alert alert-danger">' . $errors . '</div>';
            }
            if(empty($formArray)){

                $image = rand(0, 100000) . '_' . $imageName;
                move_uploaded_file($imageTmp, "upload\images\\" . $image);

                $lestId = $db->insert('items', [
                    'Name'         => $name,
                    'Description'        => $descrip,
                    'Price'        => $price,
                    'Date'        => date("m-d-Y"),
                    'quentity'     => $quentity,
                    'image'        => $image,
                    'Status'        => 0,
                    'cat_id'          => $category
                ]);
                $TheMsg = "<div class='alert alert-success'> Record Inserted</div>";
                $db->redirectHome($TheMsg, 'back', 5);
            }
            echo "</div>";
        }else{
            $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
            redirectHome($TheMsg, 'back', 5);
        }
    }elseif($do == 'Edit'){ 
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $rows = $db->table("items")->where('ItemID', $itemid)->get(); 
        foreach($rows as $row){?>
            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <div class="form-container">
                    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                        <!-- Start Name -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="name" value="<?php echo $row['Name']; ?>" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <!-- End Name -->
                        <!-- Start Description -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="descrip" value="<?php echo $row['Description']; ?>" class="form-control">
                            </div>
                        </div>
                        <!-- End Description -->
                        <!-- Start Price -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="price" class="form-control" value="<?php echo $row['Price']; ?>">
                            </div>
                        </div>
                        <!-- End Price -->
                        <!-- Start Quentity -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Quentity</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="number" name="quentity" class="form-control" value="<?php echo $row['quentity']; ?>">
                            </div>
                        </div>
                        <!-- End Quentity -->
                        <!-- Start Categories Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10 col-md-9">
                                <select name="category" class="form-control">
                                    <option value="0">...</option>
                                    <?php
                                        $cats = $db->table("categories")->get();
                                        foreach($cats as $cat){
                                            echo '<option value="' . $cat['ID'] . '"';
                                            if($row['cat_id'] == $cat['ID']){echo 'selected';}
                                            echo '>' . $cat['Name'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Categories Field -->
                        <!-- Start Image Field -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <!-- End Image Field -->
                        <!-- Start Submit -->
                        <div class="mb-2 row">
                            <div class="offset-sm-2 col-sm-10">
                                <input type="submit" value="Update" class=" btn btn-primary ">
                            </div>
                        </div>
                        <!-- End Submit -->
                    </form>
                </div>
            </div>    
<?php }}elseif($do == 'Update'){
        echo "<h1 class='text-center'>Update Item</h1>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $imageName = $_FILES['image']['name'];
            $imageType = $_FILES['image']['type'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp  = $_FILES['image']['tmp_name'];

            $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");

            @$imageExtension = strtolower(end(explode('.', $imageName)));
            $id = $_POST['itemid'];
            $name = $_POST['name'];
            $descrip = $_POST['descrip'];
            $price = $_POST['price'];
            $quentity = $_POST['quentity'];
            $category = $_POST['category'];

            $formArray = array();
            if(empty($name)){
                $formArray[] = 'Item name Cant Be <strong>Empty</strong>';
            }
            if(empty($descrip)){
                $formArray[] = 'Description item Cant Be <strong>Empty</strong>';
            }
            if(empty($price)){
                $formArray[] = 'Price Item Cant Be <strong>Empty</strong>';
            }
            if(empty($quentity)){
                $formArray[] = 'Quentity Item Cant Be <strong>Empty</strong>';
            }
            if(empty($category)){
                $formArray[] = 'Category Item Cant Be <strong>Empty</strong>';
            }
            if(! empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension)){
                $formArray[] = 'This Extension Is Not <strong>Allowed</strong>';
            }
            if(empty($imageName)){
                $formArray[] = 'Image Is <strong>Required</strong>';
            }
            if($imageSize > 4194304){
                $formArray[] = 'Image Cant Be Larger Than <strong>4MB</strong>';
            }
            foreach($formArray as $errors){
                echo '<div class="alert alert-danger">' . $errors . '</div>';
            }
            if(empty($formArray)){

                $image = rand(0, 100000) . '_' . $imageName;
                move_uploaded_file($imageTmp, "upload\images\\" . $image);
                $stmt = $db->update("items",
                 [
                    "Name" => $name,
                    "Description" => $descrip, 
                    "Price" => $price, 
                    "quentity" => $quentity, 
                    "image" => $image, 
                    "cat_id" => $category
                  ])->where($id)->exec();

                $TheMsg = "<div class='alert alert-success'>Record Update</div>";
                $db->redirectHome($TheMsg, 'back', 10);
            }
        }else{
            $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            $database->redirectHome($TheMsg);
        }
    }elseif($do == 'Delete'){
        echo "<h1 class='text-center'>Delete Item</h1>";
                
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $db->delete("items")->where($itemid)->exec();

        $TheMsg = "<div class='alert alert-success'> Record Deleted</div>";
        $db->redirectHome($TheMsg, 'back', 5);
    }else{
        $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
        $db->redirectHome($TheMsg);
    }
?>