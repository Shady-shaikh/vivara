@php
// use Session;
@endphp
<script>
  // toastr.success("aW32aqlksajdflkajsdf");
  
  @if(Session::has('success'))
  
  toastr.success("{{ Session::get('success') }}");
      // alert('test');
  @endif


  @if(Session::has('info'))

  		toastr.info("{{ Session::get('info') }}");

  @endif


  @if(Session::has('warning'))

  		toastr.warning("{{ Session::get('warning') }}");

  @endif


  @if(Session::has('error'))

  		toastr.error("{{ Session::get('error') }}");

  @endif

  @if(Session::has('message'))
  // alert('msg');
  		toastr.info("{{ Session::get('message') }}");

  @endif

</script>