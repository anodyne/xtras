<script>
	$('.js-remove-item').on('click', function(e)
	{
		e.preventDefault();

		var item = $(this).data('id');
		var admin = $(this).data('admin');

		$('#removeItem').modal({
			remote: "{{ URL::to('item') }}/" + item + "/remove/" + admin
		}).modal('show');
	});
</script>