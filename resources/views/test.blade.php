

<!-- code for mking a table with resizable header -->
@extends("layouts.panel")
@section('content')

<style type="text/css">
html,
body {
  height: 100%;
  font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  padding: 0;
  margin: 0;
}

.page-container {
  margin: 20px;
}

table {
  border-collapse: collapse;
  width: 800px;
}

td,
th {
  padding: 8px;
  border: 1px solid silver;
}

th {
  color: white;
  background: darkslategray;
}

pre {
  margin: 20px;
  padding: 10px;
  background: #eee;
  border: 1px solid silver;
  border-radius: 4px;
}

/*
   this is important!
   make sure you define this here
   or in jQuery codef
*/
.resizer {
  position: absolute;
  top: 0;
  right: -8px;
  bottom: 0;
  left: auto;
  width: 16px;    
  cursor: col-resize;       
}  
</style>
<div class="page-container">

  <h1>
            jquery-resizable - Table Column Resizing
        </h1>
  <hr />
  <p>
    This example makes the first two columns of the table resizable.
  </p>

  <hr />

  <table>
    <thead>
      <th>
        col 1
      </th>
      <th>
        col 2
      </th>
      <th>
        col 3
      </th>
      <th>
        col 4
      </th>
    </thead>

    <tbody>
      <tr>
        <td>
          Column 1
        </td>
        <td>

          Column 2
        </td>
        <td>

          Column 3
        </td>
        <td>
          Column 4
        </td>
      </tr>
      <tr>
        <td>
          Column 1
        </td>
        <td>
          Column 2
        </td>
        <td>
          Column 3
        </td>
        <td>
          Column 4
        </td>
      </tr>
    </tbody>
  </table>
  <hr />
  <p>
    To create resizable columns requires a bit of extra effort as tables don't have an easy way to create a drag handle that can be moved around.
  </p>
  <p>
    To make columns resizable, we can add an element to the right of the column to provide the handle so we have a visual indicator for dragging. The table cell to resize is made <code>position:relative</code> and the injected element is <code>position: absolute</code>    and pushed to the right of the cell to provide the drag handle. Dragging then simply resizes the cell.
  </p>
  <p>
    In practice this means you need some CSS (or jquery styling) to force the injected styling and the logic to inject the element.
  </p>

</div>
@endsection
@section('js')
<script type="text/javascript">
  //$("td,th")
$("td:first-child,td:nth-child(2),td:nth-child(3),th:first-child,th:nth-child(2),th:nth-child(3)")
  .css({
    /* required to allow resizer embedding */
    position: "relative"
  })
  /* check .resizer CSS */
  .prepend("<div class='resizer'></div>")
  .resizable({
    resizeHeight: false,
    // we use the column as handle and filter
    // by the contained .resizer element
    handleSelector: "",
    onDragStart: function(e, $el, opt) {
      // only drag resizer
      if (!$(e.target).hasClass("resizer"))
        return false;
      return true;
    }
  });
</script>
@endsection