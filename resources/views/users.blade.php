
<div class="users">
    <ul>
        @forelse($names as $name)
            <li>
                {{ $name }}
                @if(!in_array($name, $existingNames))
                    <button name="{{ $name }}" onclick="saveUser(this)">Save</button>

                @endif
            </li>
        @empty
            <li>No users found</li>
        @endforelse
    </ul>
</div>
