<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

	<!-- Toastr -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Hello, Martin</title>
  </head>
  <body>
    <div class="container">
		<div class="row">
			<div class="col-md-12 mt-5">
			<h1 class="text-center">Codeigniter CRUD</h1>
			<hr style="background-color: black; color:black; height: 1px;">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mt-2">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
				Tambah Record
				</button>

				<!--Insert Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form action="" method="post" id="form">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" id="name" class="form-control">
								</div>
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" id="email" class="form-control">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
							<button type="button" class="btn btn-outline-primary" id="add">Tambah</button>
						</div>
						</div>
					</div>
				</div>

				<!-- Edit Modal -->
				<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form action="" method="post" id="edit_form">
							<input type="hidden" id="edit_modal_id" value="">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" id="edit_name" class="form-control">
								</div>
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" id="edit_email" class="form-control">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
							<button type="button" class="btn btn-outline-primary" id="update">Perbarui</button>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-12 mt-3">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
					
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

	<!-- Toastr -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	
	<!-- SweetAlert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

	<script>
	// fungsi klik tombol "add" yang ada pada Modal
		$(document).on("click", "#add", function(e){
			e.preventDefault();

			var name = $("#name").val();
			var email = $("#email").val();

			if(name == "" || email == ""){
				alert("Kolom jangan sampai kosong");
			}else{

				$.ajax({
					url: "<?php echo base_url(); ?>insert",
					type: "post",
					dataType: "json",
					data: {
						name: name,
						email: email
					},
					success: function(data){
						fetch();
	
						if (data.response == "success"){
							toastr["success"](data.message);
	
							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
							}

							$('#exampleModal').modal('hide');
							
						}else{
							toastr["error"](data.message);
	
							toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
							}
						}
					}
				});
			}

			// fungsi ini bekerja apabila diklik tombol add form akan ditutup
			$("#form")[0].reset();
		});

		// Fetch data proses / mengambil data
		function fetch(){
			$.ajax({
				url: "<?php echo base_url(); ?>fetch",
				type: "post",
				dataType: "json",
				success: function(data){
					var tbody = "";
					var i = "1";

					for(var key in data) {
						tbody += "<tr>";
						tbody += "<td>"+ i++ + "</td>";
						tbody += "<td>"+ data[key]['name'] + "</td>";
						tbody += "<td>"+ data[key]['email'] + "</td>";
						tbody += `<td>
									<a href="#" id="del" class="btn btn-sm btn-outline-danger" value="${data[key]['id']}"><i class="fas fa-trash-alt"></i></a>
									<a href="#" id="edit" class="btn btn-sm btn-outline-info" value="${data[key]['id']}"><i class="fas fa-edit"></i></a>
								  </td>`;
						tbody += "</td>";
					}
					$("#tbody").html(tbody);
				}
			});
		}
		fetch();

		// Function delete record
		$(document).on("click", "#del", function(e){
			e.preventDefault();

			var del_id = $(this).attr("value");

			if (del_id == ""){
				alert("Delete id required");
			}else{
				const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-outline-success',
					cancelButton: 'btn btn-outline-danger mx-2'
				},
				buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
				}).then((result) => {
				if (result.value) {

					$.ajax({
						url: "<?php echo base_url(); ?>delete",
						type: "post",
						dataType: "json",
						data: {
							del_id: del_id
						},
						success: function(data){
							fetch();
							if (data.response == "success") {
								swalWithBootstrapButtons.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
								)
							}
						}
					});
				} else if (
					/* Read more about handling dismissals below */
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your imaginary file is safe :)',
					'error'
					)
				}
				})
			}
		});

		// Function edit record
		$(document).on("click", "#edit", function(e){
			e.preventDefault();

			var edit_id = $(this).attr("value");

			if (edit_id == ""){
				alert("Edit id required");
			}else{
					$.ajax({	
							url: "<?php echo base_url(); ?>edit",
							type: "post",
							dataType: "json",
							data: {
								edit_id: edit_id
							},
							success: function(data){
								if (data.response == "success") {
									$('#editModal').modal('show');
									$("#edit_modal_id").val(data.post.id);
									$("#edit_name").val(data.post.name);
									$("#edit_email").val(data.post.email);
								}else{
									toastr["error"](data.message);

									toastr.options = {
									"closeButton": true,
									"debug": false,
									"newestOnTop": false,
									"progressBar": true,
									"positionClass": "toast-top-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": "300",
									"hideDuration": "1000",
									"timeOut": "5000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}
							}
						}
					});
			}
		});

		// Update record
		$(document).on("click", "#update", function(e){
			e.preventDefault();

			var edit_id = $("#edit_modal_id").val();
			var edit_name = $("#edit_name").val();
			var edit_email = $("#edit_email").val();

			if (edit_id == "" || edit_name == "" || edit_email == "") {
				alert("Kolom jangan sampai kosong!!");
			}else{
				$.ajax({
					url: "<?php echo base_url(); ?>update",
					type: "post",
					dataType: "json",
					data: {
						edit_id: edit_id,
						edit_name: edit_name,
						edit_email: edit_email
					},

					success: function(data){
						fetch();
						if(data.response == "success") {
							$('#editModal').modal('hide');
							toastr["success"](data.message);

									toastr.options = {
									"closeButton": true,
									"debug": false,
									"newestOnTop": false,
									"progressBar": true,
									"positionClass": "toast-top-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": "300",
									"hideDuration": "1000",
									"timeOut": "5000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}
						}else{
							toastr["error"](data.message);

									toastr.options = {
									"closeButton": true,
									"debug": false,
									"newestOnTop": false,
									"progressBar": true,
									"positionClass": "toast-top-right",
									"preventDuplicates": false,
									"onclick": null,
									"showDuration": "300",
									"hideDuration": "1000",
									"timeOut": "5000",
									"extendedTimeOut": "1000",
									"showEasing": "swing",
									"hideEasing": "linear",
									"showMethod": "fadeIn",
									"hideMethod": "fadeOut"
								}
						}
					}
				});
			}
		});
	</script>
  </body>
</html>