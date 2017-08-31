resetFilters = () ->
  $('#datatable-categories th option:selected').each () -> 
    $(this).prop('selected', false);
  $('#catNameSearch').val('')
  $('#catNameSearch').keyup()
  $('#datatable-categories select').each () ->
    $(this).multiselect('refresh')
  $('input[type="checkbox"]').each (index, value) ->
    $(this).change()
    return
  return

$('body').on 'click','#resetfilter', ->
  resetFilters()
  return
