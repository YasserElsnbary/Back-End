<?php

    ob_start();

    session_start();

    $pageTitle = "Items";

    if (isset($_SESSION['Username'])) {
        
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage') 
        {       
            
            $stmt = $con->prepare(
                "SELECT 
                    items.*,
                    categories.Name AS category_Name,
                    users.Username 
                from 
                    items
            INNER JOIN 
                    categories 
            ON 
                    categories.ID = Items.Cat_ID
            INNER JOIN 
                    users 
            ON 
                    users.UserID = items.Member_ID"
            );
            
            $stmt->execute();

            $items = $stmt->fetchAll();
            
        ?>

            <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-bordered">
                    
                    <tr>

                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>

                    </tr>

                    <?php 
                    
                        foreach($items as $item) {
                            echo "<tr>";
                                echo "<td>" . $item['Item_ID']    .  "</td>";
                                echo "<td>" . $item['Name']  .  "</td>";
                                echo "<td>" . $item['Description']     .  "</td>";
                                echo "<td>" . $item['Price']  .  "</td>";
                                echo "<td>" . $item['Add_Date']      .  "</td>";
                                echo "<td>" . $item['category_Name']      .  "</td>";
                                echo "<td>" . $item['Username']      .  "</td>";
                                echo "
                                    <td> 
                                        <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
                                        <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger'><i class='fa fa-close'></i>Delete </a>";
                                        if ($item['Approve'] == 0) {
                                            echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] .  "' class='btn btn-info activate'>
                                            <i class='fa fa-check'></i>Activate</a>";
                                        }
                                echo "</td>";
                            echo "</tr>";


                        }
                    
                    ?>


                    </table>
                </div>

                <a href='items.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>Add New Items</a>

            </div>


            <?php
        }
        elseif ($do == 'Add') 
        {       
            ?>
            <h1 class="text-center">Add New Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Insert" method="POST">
                        
                        
                        <!-- start Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Name of the Item">
                            </div>
                        </div>
                        <!-- end Name Filed -->

                        <!-- start Description Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="description" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Description of the Item">
                            </div>
                        </div>
                        <!-- end Description Filed -->

                        <!-- start Price Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="price" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="price of the Item">
                            </div>
                        </div>
                        <!-- end Price Filed -->

                        <!-- start Country Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="country" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Country of Made">
                            </div>
                        </div>
                        <!-- end Country Filed -->

                        <!-- start Status Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- end Status Filed -->

                        <!-- start Members Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Members</label>
                            <div class="col-sm-10">
                                <select name="member" class="form-control">
                                    <option value="0">...</option>
                                    <?php
                                    
                                        $stmt = $con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                                        }
                                    
                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end Members Filed -->

                         <!-- start Category Filed -->
                         <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category" class="form-control">
                                    <option value="0">...</option>
                                    <?php
                                    
                                        $stmt2 = $con->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats = $stmt2->fetchAll();
                                        foreach ($cats as $cat) {
                                            echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                        }
                                    
                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end Category Filed -->
                
                        <!-- start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Item" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!-- end Submit Filed -->
                        
                    </form>
                </div>
                <?php
        }
        elseif ($do == 'Insert') 
        {       
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo "<h1 class='text-center'>Add Item</h1>";

                echo "<div class='container'>";
    
                // Get Vairables From the form
    
                $name    = $_POST['name'];
                $desc    = $_POST['description'];
                $price   = $_POST['price'];
                $country = $_POST['country'];
                $status  = $_POST['status'];
                $member  = $_POST['member'];
                $cat     = $_POST['category'];
                
                $formErrors = array();
    
                if (empty($name)) {
                    
                    $formErrors[] = "Name Can't be <strong>Empty</strong>";
                }
    
                if (empty($desc)) {
                    
                    $formErrors[] = "Description Can't be <strong>Empty</strong>";
                }
    
                if(empty($price)) {
                    $formErrors[] = "Price Can't be <strong>Empty</strong>";
                }

                if(empty($country)) {
                    $formErrors[] = "Country Can't be <strong>Empty</strong>";
                }
    
                if($status === 0) {
                    $formErrors[] = "You Must Choose the <strong>Status</strong>";
                }

                if($member === 0) {
                    $formErrors[] = "You Must Choose the <strong>Member</strong>";
                }

                if($cat === 0) {
                    $formErrors[] = "You Must Choose the <strong>Category</strong>";
                }
    
               foreach($formErrors as $error) {
    
                echo "<div class='alert alert-danger'>" .  $error . "</div><br/>";
               }
    
               if(empty($formErrors)) 
               {
        
                    $stmt = $con->prepare("INSERT INTO 
                                        items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID)
                                    VALUES
                                            (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(),:zcat, :zmember);
                                    ");
                    $stmt->execute(array(
                        'zname'    => $name,
                        'zdesc'    => $desc,
                        'zprice'   => $price,
                        'zcountry' => $country,
                        'zstatus'  => $status,
                        'zcat'     => $cat,
                        'zmember'  => $member,

                    ));
                    
                    // Echo Success Message
        
                    echo "<div class='alert alert-success'>" . $stmt->rowCount() . " Recorded Inserted</div>";
                    
                }
            
            }   
            else {
                $theMsg = "<div class='alert alert-danger'>You Can't Browese This Directory</div>";

                redirectHome($theMsg);
            }
            echo "</div>";

        } 
        elseif ($do == 'Edit')
        {       
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
            
            $stmt->execute(array($itemid));
            
            $item = $stmt->fetch();
            
            $count = $stmt->rowCount();

            if($count > 0 ) { ?> 
            <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="itemid" value="<?php  echo $itemid; ?>">
                        
                        
                        <!-- start Name Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Name of the Item"
                                    value="<?php echo $item['Name']?>">
                            </div>
                        </div>
                        <!-- end Name Filed -->

                        <!-- start Description Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="description" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Description of the Item"
                                    value="<?php echo $item['Description']?>">
                            </div>
                        </div>
                        <!-- end Description Filed -->

                        <!-- start Price Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="price" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="price of the Item"
                                    value="<?php echo $item['Price']?>">
                            </div>
                        </div>
                        <!-- end Price Filed -->

                        <!-- start Country Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10">
                                <input 
                                    type="text" 
                                    name="country" 
                                    class="form-control"  
                                    required="required" 
                                    placeholder="Country of Made"
                                    value="<?php echo $item['Country_Made']?>">
                            </div>
                        </div>
                        <!-- end Country Filed -->

                        <!-- start Status Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="0">...</option>
                                    <option value="1" <?php if($item['Status'] == 1 ) { echo 'selected'; }?> >New</option>
                                    <option value="2" <?php if($item['Status'] == 2 ) { echo 'selected'; }?>>Like New</option>
                                    <option value="3" <?php if($item['Status'] == 3 ) { echo 'selected'; }?>>Used</option>
                                    <option value="4" <?php if($item['Status'] == 4 ) { echo 'selected'; }?>>Very Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- end Status Filed -->

                        <!-- start Members Filed -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Members</label>
                            <div class="col-sm-10">
                                <select name="member" class="form-control">
                                    <option value="0">...</option>
                                    <?php
                                    
                                        $stmt = $con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='" . $user['UserID'] . "'";
                                                 if($item['Member_ID'] == $user['UserID'] ) { echo 'selected'; } 
                                            echo ">" . $user['Username'] . "</option>";
                                        }
                                    
                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end Members Filed -->

                         <!-- start Category Filed -->
                         <div class="form-group">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category" class="form-control">
                                    <option value="0">...</option>
                                    <?php
                                    
                                        $stmt2 = $con->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats = $stmt2->fetchAll();
                                        foreach ($cats as $cat) {
                                            echo "<option value='" . $cat['ID'] . "'";
                                            if($item["Cat_ID"] == $cat["ID"]) {echo 'selected'; }
                                            echo ">" . $cat['Name'] . "</option>";
                                        }
                                    
                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- end Category Filed -->
                
                        <!-- start Submit Filed -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save Edit" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!-- end Submit Filed -->
                        
                    </form>
                    <?php
                        $stmt = $con->prepare(
                            "SELECT 
                            comments.*, items.Name as iname, users.Username as uname
                            FROM 
                                comments
                            INNER JOIN
                                items
                            ON
                                items.Item_ID = comments.item_id
                            INNER JOIN
                                users
                            ON
                                users.UserID = comments.user_id
                            WHERE 
                                items.Item_ID = ?
                            ");
            
                        $stmt->execute(array($itemid));

                        $rows = $stmt->fetchAll();

                    if (! empty($rows)) 
                    { 

                    
                    ?>

                    <h1 class="text-center">Manage [ <?php echo $item['Name']?> ] Comments</h1>
                    <div class="table-responsive">
                        <table class="main-table table table-bordered">
                        
                        <tr>
                            
                            <td>Comment</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>

                        </tr>

                        <?php 
                        
                            foreach($rows as $row) {
                                echo "<tr>";
                                    echo "<td>" . $row['comment']  .  "</td>";
                                    echo "<td>" . $row['uname']  .  "</td>";
                                    echo "<td>" . $row['comment_date']      .  "</td>";
                                    echo "
                                        <td> 
                                            <a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
                                            <a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger'><i class='fa fa-close'></i>Delete </a>";
                                        
                                            if ($row['status'] == 0 ) {
                                                echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='activate btn btn-info'><i class='fa fa-close'></i> Approve</a>";
                                            }

                                            echo "</td>";
                                echo "</tr>";


                            }
                        
                        ?>
                        </table>
                    </div>  
                    <?php }?>                
                </div>
                <?php
                    
            } else {
                echo  "<div class='container'>";

                    $theMsg = "<div class='alert alert-danger'>There is Not Such ID</div>";

                    redirectHome($theMsg);

                echo '</div>';
            }
    
        }
        elseif ($do ==  'Update') 
        {       
            echo "<h1 class='text-center'>Update Item</h1>";

            echo "<div class='container'>";

            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
            {


                // Get Vairables From the form

                $id      = $_POST['itemid'];
                $name    = $_POST['name'];
                $desc    = $_POST['description'];
                $price   = $_POST['price'];
                $country = $_POST['country'];
                $status  = $_POST['status'];
                $cat     = $_POST['category'];
                $member  = $_POST['member'];
                

                // Validate Form 

                $formErrors = array();
    
                if (empty($name)) {
                    
                    $formErrors[] = "Name Can't be <strong>Empty</strong>";
                }
    
                if (empty($desc)) {
                    
                    $formErrors[] = "Description Can't be <strong>Empty</strong>";
                }
    
                if(empty($price)) {
                    $formErrors[] = "Price Can't be <strong>Empty</strong>";
                }

                if(empty($country)) {
                    $formErrors[] = "Country Can't be <strong>Empty</strong>";
                }
    
                if($status === 0) {
                    $formErrors[] = "You Must Choose the <strong>Status</strong>";
                }

                if($member === 0) {
                    $formErrors[] = "You Must Choose the <strong>Member</strong>";
                }

                if($cat === 0) {
                    $formErrors[] = "You Must Choose the <strong>Category</strong>";
                }
    
               foreach($formErrors as $error) {
    
                echo "<div class='alert alert-danger'>" .  $error . "</div><br/>";
               }
                if(empty($formErrors)) 
                {

                    // Update The DataBase With The Info

                    $stmt = $con->prepare(
                        "UPDATE 
                            items 
                        SET 
                            Name = ?,
                            description = ?,
                            Price = ?,
                            Country_Made = ?, 
                            Status = ?, 
                            Cat_ID = ?, 
                            Member_ID = ? 
                        WHERE 
                            Item_ID = ?"
                        );
                    $stmt->execute(array($name,$desc,$price, $country, $status, $cat, $member, $id));
        
                    // Echo Success Message
        
                    echo $stmt->rowCount() . " Recorded Updated";


                    $errorMsg = "You Can't Browese This Directory";

                    redirectHome($errorMsg, 6);

                }

            }
            else 
            {
                echo "You Can't Browese This Directory";
            }
            echo "</div>";
        }
        elseif ($do == 'Delete')
        {       
            echo "<h1 class='text-center'>Delete Item</h1>";

        echo "<div class='container'>";

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            $check =  checkItem('Item_ID', 'items', $itemid);

            if($check > 0 ) { 

                $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

                $stmt->bindParam(":zid", $itemid);

                $stmt->execute();

                $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";

                redirectHome($theMsg, 'back');

            }
            else {

                $theMsg =  "<div class='alert alert-danger'>This ID Is Not Exist</div>";

                redirectHome($theMsg);
            }
        
            echo "</div>";

        }
        elseif ($do == 'Approve')
        {       
            
            echo "<h1 class='text-center'>Approve Item</h1>";

            echo "<div class='container'>";

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

            $check = checkItem('Item_ID', 'items', $itemid);

            if($check > 0 ) { 

                $stmt = $con->prepare("UPDATE items Set Approve = 1 WHERE Item_ID = ?");

                $stmt->execute(array($itemid));

                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Item Approved</div>";
                
                redirectHome($theMsg, 'back');

            }
            else {

                echo "Not Exist";
            }
        
            echo "</div>";


        }

        include $tpl . "footer.php";
    }
    else {
        
        header('Location: index.php');
        
        exit();
    }
    
    
?>