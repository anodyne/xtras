<script>
	$('.js-remove-item').on('click', function(e)
	{
		e.preventDefault();

		var item = $(this).data('id');

		$('#removeItem').modal({
			remote: "{{ URL::to('item') }}/" + item + "/remove"
		}).modal('show');
	});
</script>