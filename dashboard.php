<?php
  require_once('connection.php');
  if(!isset($_SESSION["admin_data"])){
    header("location:index.php");
    die;
  }
  $_SESSION['pages'] = 'Dashboard';

  $sql="SELECT * FROM tbl_content";
  $result = mysqli_query($conn, $sql);
  $total_content = mysqli_num_rows($result);

  $sql1="SELECT * FROM tbl_content_category";
  $result1 = mysqli_query($conn, $sql1);
  $total_category = mysqli_num_rows($result1);

  $sql2="SELECT * FROM tbl_content_type";
  $result2 = mysqli_query($conn, $sql2);
  $total_type = mysqli_num_rows($result2);

  $sql3="SELECT * FROM tbl_user";
  $result3 = mysqli_query($conn, $sql3);
  $total_user = mysqli_num_rows($result3);

  $sql4="SELECT cc.category_name, COUNT(c.id) AS total_no 
    FROM tbl_content_category as cc
    LEFT JOIN tbl_content as c ON (c.content_category = cc.id) 
    GROUP BY content_category";
  $result4 = mysqli_query($conn, $sql4);
  $total_category_type = mysqli_num_rows($result4);

  $content_query = "SELECT c.*,cc.category_name, ct.type_name 
    FROM tbl_content as c 
    LEFT JOIN tbl_content_category as cc ON (c.content_category = cc.id) 
    LEFT JOIN tbl_content_type as ct ON (c.content_type = ct.id)
    ORDER BY c.id DESC LIMIT 5
  ";
  $result_content = mysqli_query($conn, $content_query);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Dashboard</title>
    <?php require_once('common/loadStyle.php');?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php require_once('common/header.php');?>

        <?php require_once('common/leftmenu.php');?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper back-white">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?php echo $total_content?></h3>

                                    <p>Content</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="content.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo $total_category?></h3>

                                    <p>Content Category</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a href="content_category.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo $total_type?></h3>

                                    <p>Content type</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a href="content_type.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo $total_user?></h3>

                                    <p>User</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="user.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <?php if ($total_category_type > 0){
            while($row = mysqli_fetch_assoc($result4)) { ?>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo $row['total_no'] ?></h3>
                                    <p><?php echo $row['category_name'] ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <a href="content.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-top-line">
                                <div class="card-header">
                                    <h3 class="card-title pull-left float-l">Content List</h3>

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form method="post" name="content_form" id="content_form">
                                        <div class="table-responsive">
                                            <table id="content_data" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Content</th>
                                                        <th>Tag</th>
                                                        <th>Content Category</th>
                                                        <th>Content Type</th>
                                                        <th>Date Added</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                  if (mysqli_num_rows($result_content) > 0) 
                  {
                    while($row = mysqli_fetch_assoc($result_content)) { ?>
                                                    <tr>
                                                        <td><?php echo strip_tags(html_entity_decode($row['content']));?>
                                                        </td>
                                                        <td><?php echo $row['tag'];?></td>
                                                        <td><?php echo $row['category_name'];?></td>
                                                        <td><?php echo $row['type_name'];?></td>
                                                        <td><?php echo date("d-m-Y",strtotime($row['date_added']));?>
                                                        </td>
                                                    </tr>
                                                    <?php } }
                  ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php require_once('common/footer.php');?>
    </div>
    <!-- ./wrapper -->

    <?php require_once('common/loadScript.php');?>


    <?php
  if(isset($_SESSION['popup_show']) && $_SESSION['popup_show']){?>
    <script type="text/javascript">
    toastr.success('Login Successfull');
    </script>
    <?php
    unset($_SESSION['popup_show']);
   } ?>


</body>

</html>