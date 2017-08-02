
listingInformation = ->
  `var i`
  form = $('<form></form>')
  form.attr 'method', 'post'
  form.attr 'action', '/add_listing'
  contacts = {}
  contact_IDs = document.getElementsByName('contact_IDs')
  value = document.getElementsByName('contacts')
  contact_verified = document.getElementsByName('verified_contact')
  contact_visible = document.getElementsByName('visible_contact')
  i = 0
  while i < contact_IDs.length
    if value[i].value != ''
      contact = {}
      contact['id'] = contact_IDs[i].value
      # contact['email'] = emails[i].value;
      contact['verify'] = if contact_verified[i].checked then '1' else '0'
      contact['visible'] = if contact_visible[i].checked then '1' else '0'
      contacts[i] = contact
    i++
  parameters = {}
  parameters['listing_id'] = null
  parameters['step'] = 'listing_information'
  parameters['title'] = document.getElementsByName('listing_title')[0].value
  type = document.getElementsByName('business_type')
  i = 0
  while i < type.length
    if type[i].checked
      parameters['type'] = type[i].value
    i++
  # parameters['type'] = '11';
  parameters['primary_email'] = if document.getElementsByName('primary_email')[0].checked then '1' else '0'
  parameters['primary_phone'] = '0'
  parameters['contacts'] = JSON.stringify(contacts)
  $.each parameters, (key, value) ->
    field = $('<input></input>')
    field.attr 'type', 'hidden'
    field.attr 'name', key
    field.attr 'value', value
    form.append field
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  return

validateListing = (event) ->
  instance = $('#info-form').parsley()
  if !instance.isValid()
    return false
  event.preventDefault()
  if $('#listing_id').val() == ''
    # console.log(true);
    $('#duplicate-listing').modal 'show'
    $('#duplicate-listing').on 'hidden.bs.modal', (e) ->
      listingInformation()
      return
  else
    # console.log(true);
    listingInformation()
  return
