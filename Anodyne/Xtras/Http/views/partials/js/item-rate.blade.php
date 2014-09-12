<script>
	$('.rating-input').on('change', function(e)
	{
		e.preventDefault();

		var value = $(this).val();
		var item = $(this).data('item');

		$.ajax({
			url: "{{ route('item.ajax.rate') }}",
			type: "POST",
			data: {
				item: item,
				rating: value,
				"_token": "{{ csrf_token() }}"
			}
		});
	});
</script>