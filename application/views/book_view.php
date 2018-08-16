<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Belajar Codeigniter dengan AJax</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/datatable/css/dataTables.bootstrap.min.css') ;?>">
</head>
<body>
    
    <div class="container">
        <h1 class="text-center">Belajar Codeigniter dengan AJax</h1>
        <h3 class="text-center">Toko Buku</h3>
        <br><br>
        <button class="btn btn-success" onclick="add_book()"><i class="glyphicon glyphicon-plus"></i> Add Book</button>
        <br><br>
        <table class="table table-striped table-bordered" id="book_table">
            <thead>
                <tr>
                    <th class="text-center">Book Id</th>
                    <th class="text-center">Book ISBN</th>
                    <th class="text-center">Book Title</th>
                    <th class="text-center">Book Author</th>
                    <th class="text-center">Book Category</th>
                    <th class="text-center">Action</th>
                </tr>            
            </thead>    
            <tbody>
            <?php foreach($book as $b){ ?>
                <tr>
                    <td class="text-center"><?php echo $b->book_id;?></td>
                    <td class="text-center"><?php echo $b->book_isbn;?></td>
                    <td class="text-center"><?php echo $b->book_title;?></td>
                    <td class="text-center"><?php echo $b->book_author;?></td>
                    <td class="text-center"><?php echo $b->book_category;?></td>
                    <td class="text-center">
                        <button class="btn btn-warning" onclick="edit_book(<?php echo $b->book_id; ?>)"><i class="glyphicon glyphicon-edit"></i></button>
                        <button class="btn btn-danger" onclick="delete_book(<?php echo $b->book_id; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>           
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Book</h4>
        </div>
        <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="book_id">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Book ISBN</label>
                        <div class="col-md-9">
                            <input type="text" name="book_isbn" placeholder="Book ISBN" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Book Title</label>
                        <div class="col-md-9">
                            <input type="text" name="book_title" placeholder="Book Title" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Book Author</label>
                        <div class="col-md-9">
                            <input type="text" name="book_author" placeholder="Book Author" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Book Category</label>
                        <div class="col-md-9">
                            <input type="text" name="book_category" placeholder="Book Category" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="save()">Submit</button>
        </div>
        </div>
    </div>
    </div>

    <script src="<?php echo base_url('assets/jquery/jquery.min.js') ; ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ; ?>"></script>
    <script src="<?php echo base_url('assets/datatable/js/jquery.dataTables.min.js') ; ?>"></script>
    <script src="<?php echo base_url('assets/datatable/js/dataTables.bootstrap.min.js') ; ?>"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#book_table').DataTable();
        });

        var save_method;
        var table;

        function add_book(){
            save_method = 'add';
            $('#form')[0].reset();
            $('#myModal').modal('show');
        }
        
        function save(){
            var url;

            if(save_method == 'add'){
                url = '<?php echo site_url('index.php/book/book_add') ; ?>';
            } else {
                url = '<?php echo site_url('index.php/book/book_edit') ; ?>';
            }

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data){
                    $('#myModal').modal('hide');
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error Add / Update Data');
                }
            });
        }

        function edit_book(id){
            save_method = 'update';
            $('#form')[0].reset();

            $.ajax({
                url: "<?php echo site_url('index.php/book/ajax_edit'); ?>/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('[name="book_id"]').val(data.book_id);
                    $('[name="book_isbn"]').val(data.book_isbn);
                    $('[name="book_title"]').val(data.book_title);
                    $('[name="book_author"]').val(data.book_author);
                    $('[name="book_category"]').val(data.book_category);

                    $('#myModal').modal('show');

                    $('.modal-title').text('Edit Book');
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Error Get Data');
                }
            });
        }

        function delete_book(id){
            if (confirm('Are you sure delete this data?')){

                $.ajax({
                    url: "<?php echo site_url('index.php/book/book_delete'); ?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Delete Data Error');
                    }
                });
            }
        }

    </script>

</body>
</html>