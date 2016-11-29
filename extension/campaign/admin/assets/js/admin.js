$(document).on('click','[data-type="template-show"]',function () {
  _element=$(this);
  _dataId=_element.attr('data-id');
  $('#modalTemplateContent').modal('show');
    $('.modal-title').text('');
    $('.modal-body').html('Loading...');
  $.ajax({
      url: 'template-data.php',
      type: 'POST',
      data: {
          templateId: _dataId
      },
      dataType: 'json',
      success: function(data) {
          if (data.code==0) {
            $('.modal-title').text('Template : '+data.name);
            $('.modal-body').html(data.content);
            _html = '';
            $('.modal-body').find('.sortable-row').each(function() {
                _html += $(this).find('.sortable-row-content').html().split('contenteditable="true"').join('');
            });
            $('.modal-body').html(_html);
            //  $('.sortable-row-actions').remove();
          }else {
            $('.modal-body').html('Ooopps.Something went wrong');
          }
      },
      error: function() {}
  });

});
$(document).on('click','[data-type="template-delete"]',function () {
  if (confirm('Are you sure?')==false) {
   return;
  }


  _element=$(this);
  _dataId=_element.attr('data-id');
  $.ajax({
      url: 'template-delete.php',
      type: 'POST',
      data: {
          templateId: _dataId
      },
      dataType: 'json',
      success: function(data) {
          if (data.code==0) {
            _element.parents('tr').remove();
            $('#datatable-responsive').DataTable();
          }else {
            alert('Ooopps.Something went wrong');
          }

      },
      error: function() {}
  });
});


$(document).on('click','[data-type="user-delete"]',function () {
  if (confirm('Are you sure?')==false) {
   return;
  }


  _element=$(this);
  _dataId=_element.attr('data-id');
  $.ajax({
      url: 'user-delete.php',
      type: 'POST',
      data: {
          userId: _dataId
      },
      dataType: 'json',
      success: function(data) {
          if (data.code==0) {
            _element.parents('tr').remove();
            $('#datatable-responsive').DataTable();
          }else {
            alert('Ooopps.Something went wrong');
          }
      },
      error: function() {}
  });
});

$(document).on('submit','.users-insert-form',function () {
  $('.label-error').text('');
  _element = $('#send');
  if (_element.attr('disabled') == 'disabled') {
      return;
  }
   // evaluate the form using generic validaing
   if (!validator.checkAll($(this))) {
     return false;
   }
   // evaluate the form using generic validaing
   if (!validator.checkAll($(this))) {
     return false;
   }
   _element.attr('disabled', 'disabled');
   _element.text('Loading...');

   _name=$('#name').val();
   _login=$('#login').val();
   _email=$('#email').val();
   _password=$('#password').val();
   _isAdmin=$('#isAdmin').is(':checked')==true?'1':'0';
   _isUser=$('#isUser').is(':checked')==true?'1':'0';


   $.ajax({
       url: 'users-insert.php',
       type: 'POST',
       data: {
           Login: _login,
           Pass: _password,
           Name: _name,
           Email: _email,
           isAdmin: _isAdmin,
           isUser: _isUser
       },
       dataType: 'json',
       success: function(data) {
           if (data.code==0) {
             window.location.href='index.php?page=users';
           }else {
             $('.label-error').text(data.message);
             _element.removeAttr('disabled');
             _element.text('Submit');
           }
       },
       error: function() {
         $('.label-error').text('Has an error');
         _element.removeAttr('disabled');
         _element.text('Submit');
       }
   });

   return false;

});

$(document).on('submit','.users-edit-form',function () {
  $('.label-error').text('');
  _element = $('#send');
  if (_element.attr('disabled') == 'disabled') {
      return;
  }
   // evaluate the form using generic validaing
   if (!validator.checkAll($(this))) {
     return false;
   }
   _element.attr('disabled', 'disabled');
   _element.text('Loading...');

   _dataId = $(this).attr('data-id');
   _name=$('#name').val();
   _login=$('#login').val();
   _email=$('#email').val();
   _password=$('#password').val();
   _passwordOld=$('#passwordOld').val();
   _isAdmin=$('#isAdmin').is(':checked')==true?'1':'0';
   _isUser=$('#isUser').is(':checked')==true?'1':'0';



   $.ajax({
       url: 'users-update.php',
       type: 'POST',
       data: {
           id: _dataId,
           Login: _login,
           Pass: _password,
           PassOld:_passwordOld,
           Name: _name,
           Email: _email,
           isAdmin: _isAdmin,
           isUser: _isUser
       },
       dataType: 'json',
       success: function(data) {
           if (data.code==0) {
             window.location.href='index.php?page=users';
           }else {
             $('.label-error').text(data.message);
             _element.removeAttr('disabled');
             _element.text('Submit');
           }
       },
       error: function() {
         $('.label-error').text('Has an error');
         _element.removeAttr('disabled');
         _element.text('Submit');
       }
   });

   return false;

});
