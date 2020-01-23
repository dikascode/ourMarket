
<div class="col-md-12">
    <div class="row">
        <h1 class="page-header">
        All Orders

        </h1>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>

            <tr>
                <th>Id</th>
                <th>Amount</th>
                <th>Transaction</th>
                <th>Currency</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php display_orders(); ?>
            </tbody>
        </table>
    </div>