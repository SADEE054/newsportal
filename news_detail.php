<?php
include "layout/head.php";
?>

<body>
    <div class="container-scroller">
        <div class="main-panel">
            <!-- partial:partials/_navbar.html -->
            <?php
            include "layout/header.php";
            ?>
        </div>


        <div class="content-wrapper">
            <div class="container">
                <div class="row justify-content-center" data-aos="fade-up">
                    <div class="col-xl-10 stretch-card grid-margin">
                        <div class="position-relative">

                            <?php
                            if (isset($_GET['id']) && !empty($_GET['id'])) {

                                $id = $_GET['id'];

                                $sql = "SELECT post.*, category.name as categoryName FROM post INNER JOIN category ON post.category_id = category.id  WHERE post.id=:id";

                                $stmp = $pdo->prepare($sql);
                                $stmp->bindParam(':id', $id, PDO::PARAM_INT);
                                $stmp->execute();
                                $post = $stmp->fetch(PDO::FETCH_OBJ);
                            }

                            ?>

                            <h1><?php echo $post->title; ?></h1>

                            <h3><?php echo $post->categoryName; ?></h3>

                            <img class="img-fluid" src="admin/<?php echo $post->image; ?>" alt="">

                            <p class="py-2">
                                <?php echo  html_entity_decode($post->description) ?>
                            </p>
                            
                            <ul class="list-inline d-flex gap-3">
                                <li><i class="fa fa-tags mt-5"></i></li>
                                <?php
                                $select = "SELECT tag.* FROM tag INNER JOIN post_tag ON tag.id = post_tag.tag_id WHERE post_tag.post_id=:postId";
                                $stmt = $pdo->prepare($select);
                                $stmt->bindParam(':postId', $post->id, PDO::PARAM_INT);
                                $stmt->execute();
                                $tags = $stmp->fetchAll(PDO::FETCH_OBJ);
                                $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                                if ($tags) {
                                  foreach ($tags as $key => $tag) { ?>
                                    <li><a class="btn btn-light" href="#"><?php echo $tag->name; ?></a> </li>
                                <?php
                                  }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- main-panel ends -->
        <!-- container-scroller ends -->

        <!-- partial:partials/_footer.html -->
        <?php
        include "layout/footer.php";
        ?>
        <?php
        include "layout/script.php";
        ?>
</body>

</html>