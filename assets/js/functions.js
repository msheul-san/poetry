function deletePoem(poemId)
{
	$.post('/assets/php/deletepoem.php', {id: poemId}).done(function(data)
	{
		if (data != 0)
		{
			$('#' + poemId + '_href_container').hide('slow'); 	
		}
	});
}

