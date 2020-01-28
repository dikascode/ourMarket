     
      <div id="page-wrapper">

            <div class="container-fluid">

             <div class="row">

<h1 class="page-header">
   All Reports

</h1>

<h2 class="bg-success">

<?php display_message(); ?></h2>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Product Id</th>
           <th>Order Id</th>
           <th>Price</th>
           <th>Product Title</th>
           <th>Product Quantity</th>
      </tr>
    </thead>
    <tbody>

    <?php get_reports(); ?> 
    
   </tbody>
</table>











                
                 


             </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->


