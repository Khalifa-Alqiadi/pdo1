<?php
    include "header.php";
    include "database.php";
    $database = new Database();
    $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';

    if($do == 'Manage'){
        $rows = $database->getAllTable("*", "items", "", '', "ItemID", ""); ?>
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

                        foreach($rows as $row){

                            echo "<tr>" .
                                    "<td>" . $row['ItemID'] . 
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
                                    $allCats = $database->getAllTable("*", "categories", "", '', "ID", "");
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
                $table = "items(Name, Description, Price, Date, quentity, image, Status, cat_id)";
                $values = "VALUES(:zname, :zdescr, :zprice, now(), :zquentity, :zimage, 0, :zcat)";
                $stmt = $database->insertData($table, $values);
                $stmt->execute(array(
                    'zname'         => $name,
                    'zdescr'        => $descrip,
                    'zprice'        => $price,
                    'zquentity'     => $quentity,
                    'zimage'        => $image,
                    'zcat'          => $category
                ));
                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                $database->redirectHome($TheMsg, 'back', 5);
            }
            echo "</div>";
        }else{
            $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
            redirectHome($TheMsg, 'back', 5);
        }
    }elseif($do == 'Edit'){ 
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $row = $database->selectByID("items", $itemid); ?>
            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <div class="form-container">
                    <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                        <!-- Start Name -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="name" value="<?php echo $row['Name']; ?>" class="form-control" autocomplete="off" required="required">
                            </div>
                        </div>
                        <!-- End Name -->
                        <!-- Start Description -->
                        <div class="mb-2 row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-md-9">
                                <input type="text" name="descrip" value="<?php echo $row['Description']; ?>" class="form-control" required="required">
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
                                        $cats = $database->getAllTable("*", "categories", "", "", "ID", "ASC", "");
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
                                <input type="file" name="image" class="form-control" required="required">
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
<?php }elseif($do == 'Update'){
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
                $stmt = $database->updateData("items", "Name = ?, Description = ?, Price = ?, quentity = ?, image = ?, cat_id = ?", "ItemID = ?");
                $stmt->execute(array($name, $descrip, $price, $quentity, $image, $category, $id));

                $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Update</div>';
                $database->redirectHome($TheMsg, 'back');
            }
        }else{
            $TheMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            $database->redirectHome($TheMsg);
        }
    }elseif($do == 'Delete'){
        echo "<h1 class='text-center'>Delete Item</h1>";
                
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $database->deleteRecord("items", "ItemID", $itemid);

        $TheMsg = "<div class='alert alert-success'> Record Deleted</div>";
        $database->redirectHome($TheMsg, 'back', 5);
    }else{
        $TheMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
        $database->redirectHome($TheMsg);
    }
?>