<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>volume</th>
        <th>price</th>
        <th>description</th>
        <th>enabled</th>
        <th colspan="2">Action</th>
    </tr>
    @foreach($wastecontainer as $wastelist)
    <tr>
        <td>{{$wastelist->id}}</td>
        <td>{{$wastelist->name}}</td>
        <td>{{$wastelist->volume}}</td>
        <td>{{$wastelist->price}}</td>
        <td>{{$wastelist->description}}</td>
        <td>{{$wastelist->enabled}}</td>
        <?php 
        $encrypt_id= enCrypt($wastelist->id);

        ?>
        <td>
            <form action="{{route('WasteContainer.edit', $encrypt_id)}}" method="GET">
                @csrf
                <button type="submit">Edit</button>
            </form>
        </td>
        <td>
            <form action="{{route('WasteContainer.destroy', $wastelist->id)}}" method="POST">
                @csrf
                @method('delete')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>