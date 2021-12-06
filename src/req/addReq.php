<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/presp/PrespController.php" ?>
<?php include "../../includes/req/ReqController.php";

$drugs = new Presp();
$req = new Req();
?>
<div class="container">
    <?= $jumbo->getJumbo("Add Requisition", "Add Drug Requisition") ?>

    <?php if (isset($_GET['search'])) : ?>
        <?php $drugsList = $drugs->findBySearch($_GET['search']) ?>
    <?php else : ?>
        <?php $drugsList = $drugs->getAllPresp(); ?>
    <?php endif ?>
    <?php $carts = $req->getCart("../../includes/req/cart.txt");
    $count = 0;
    foreach ($carts as $cart) {
        if (isset($cart[2])) :
            $count = $count + 1;
        endif;
    } ?>
    <div class="row">
        <div class="col-12">

            <table class="table table-responsive-sm table-striped">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Prescription</th>
                    <th>Expiry date</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                    <form method="get">
                        <input class="form-input form-check form-group" placeholder="Search" type="text" name="search" id="">
                    </form>
                    <button onclick="refresh()" class="btn btn-default btn-sm text-left">Clear Filter</button>
                    <button onclick="modal()" class="btn btn-success btn-rounded"><?= $count ?></button>
                    <?php while ($row = $drugsList->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $row['drug_id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['presp'] ?></td>
                            <td><?= $row['expiry'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><input type="number" class="form-control" value="1" name="qty" id="qty<?= $row['drug_id'] ?>"></td>
                            <td><button title="Add To Cart" class="delete btn btn-default btn-sm fa fa-cart-plus" onclick="addToCart('<?= $row['drug_id'] ?>' , '<?= $row['name'] ?>' , '<?= $row['expiry'] ?>', '<?= $row['presp'] ?>', '<?= $row['price'] ?>')"></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>





        </div>
    </div>


    <?php include "../../includes/footer.php"; ?>


    <script>
        function refresh() {
            window.location.href = 'addReq.php';
        }


        function addToCart(id, name, expiry, presp, price) {
            event.stopPropagation();
            qty = $("#qty" + id).val();

            $.ajax({
                type: 'POST',
                url: '../../includes/req/ReqController.php',
                data: {
                    type: 'addToCart',
                    id: id,
                    name: name,
                    expiry: expiry,
                    presp: presp,
                    price: price,
                    qty: qty
                },
                beforeSend: function() {

                },
                success: function(resp) {
                    if (resp == "success") {
                        Swal.fire({
                            title: "Added To Cart",
                            width: "100",
                            position: "top-right",
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(result => {
                            window.location.reload();
                        });

                    } else {
                        Swal.fire({
                            title: "Failed to add To Cart:  " + resp,
                            width: "100",
                            position: "top-right",
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(result => {

                            window.location.reload();

                        });
                    }
                },

            });
        }

        function removeFromCart(id, name, expiry, presp, price, qty) {
            event.stopPropagation();
            $.ajax({
                type: 'POST',
                url: '../../includes/req/ReqController.php',
                data: {
                    type: 'removeFromCart',
                    id: id,
                    name: name,
                    expiry: expiry,
                    presp: presp,
                    price: price,
                    qty: qty
                },
                beforeSend: function() {

                },
                success: function(resp) {
                    if (resp == "success") {
                        Swal.fire({
                            title: "Removed From Cart",
                            width: "100",
                            position: "top-right",
                            showConfirmButton: false,
                            timer: 1000,
                        }).then(result => {
                            window.location.reload();
                        });

                    } else {
                        Swal.fire({
                            title: "Failed to Remove from cart",
                            width: "100",
                            position: "top-right",
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(result => {
                            window.location.reload();
                        });
                    }
                },

            });
        }


        function createReq(array) {
            event.stopPropagation();
            $.ajax({
                type: 'POST',
                url: '../../includes/req/ReqController.php',
                data: {
                    type: 'saveCart',
                },
                beforeSend: function() {

                },
                success: function(resp) {
                    if (resp == "success") {
                        Swal.fire({
                            title: "Requisition has been saved",
                            text: "Please wait for approval",
                            width: "100",
                            type: "success",
                            showConfirmButton: true,
                            timer: 10000,
                        }).then(result => {
                            window.location.reload();
                        });

                    } else {
                        console.log(resp);
                        Swal.fire({
                            title: "Failed to save requisition",
                            text: resp,
                            width: "100",
                            type: "error",
                            showConfirmButton: true,
                            timer: 10000,
                        }).then(result => {
                            window.location.reload();
                        });
                    }
                },

            });
        }
    </script>

    <div id="publish" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Expiry date</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php $int = 0; ?>
                            <?php $total = 0; ?>
                            <?php foreach ($carts as $value) {
                                if (isset($value[1])) :
                                    ?>
                                    <tr>
                                        <td><?= $value[0] ?></td>
                                        <td><?= $value[1] ?></td>
                                        <td><?= $value[2] ?></td>
                                        <td><?= $value[4] ?></td>
                                        <td><?= $value[5] ?></td>
                                        <td><button title="Remove From Cart" class="delete btn btn-default btn-sm fa fa-eject" onclick="removeFromCart('<?= $value[0] ?>','<?= $value[1] ?>','<?= $value[2] ?>','<?= $value[3] ?>','<?= $value[4] ?>','<?= $value[5] ?>')"></button></td>
                                    </tr>
                                    <?php
                                    $val =  $value[3] * $value[5];
                                    $total = $total + $val;
                                endif;
                                $int++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php if (isset($value[1])) : ?>
                        <h3>TOTAL PRICE = MWK <?= $total ?> </h3>
                    <?php else : ?>
                        <h4>Cart Empty</h4>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input onclick="createReq()" name="Approve" value="Approve" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
    <script>
        function modal(e) {
            $('.modal').modal('show');
        }
    </script>