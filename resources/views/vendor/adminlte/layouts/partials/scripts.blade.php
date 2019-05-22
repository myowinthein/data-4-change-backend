<!-- template default -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>

<!-- third parties -->
<script src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.2/cr-1.5.0/fh-3.1.4/datatables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js" type="text/javascript"></script>

<!-- custom -->
<script type="text/javascript" src="{{ url ('/js/general.js') }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
      $(function () {
            var url = window.location;
            // for sidebar menu but not for treeview submenu
            $('ul.sidebar-menu a').filter(function() {
                  // alert(this.href)
                  return this.href == url;
            }).parent().siblings().removeClass('active').end().addClass('active');
            // for treeview which is like a submenu
            $('ul.treeview-menu a').filter(function() {
                  return this.href == url;
            }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active').end().addClass('active')

            $('body').on('keypress', 'input[type=number]', function(event) {
                  return event.charCode >= 48 && event.charCode <= 57
            })

            $('body').on('change', 'input#inputQuantity', function(event) {
                  if (!this.value) {
                        $(this).val(0).trigger('change')
                  }
            })
      })
</script>