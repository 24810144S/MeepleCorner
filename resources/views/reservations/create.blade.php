<h1>Reserve Your Game Session</h1>

<p>Welcome, {{ session('member_name') }}</p>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="/reservation">
    @csrf

    <label>Date:</label>
    <input type="date" name="reservation_date" value="{{ old('reservation_date') }}"><br><br>

    <label>Time Slot:</label>
    <select name="time_slot">
        <option value="">-- Select a time slot --</option>
        <option value="2:00 PM - 4:00 PM">2:00 PM - 4:00 PM</option>
        <option value="4:00 PM - 6:00 PM">4:00 PM - 6:00 PM</option>
        <option value="6:00 PM - 9:00 PM">6:00 PM - 9:00 PM</option>
    </select>
    <br><br>

    <p>Select a table or room:</p>

    @foreach($spaces as $space)
        <label>
            <input type="radio" name="space_id" value="{{ $space->id }}">
            {{ $space->name }} - {{ $space->type }} - {{ $space->capacity }} players
        </label>
        <br>
    @endforeach

    <br>
    <button type="submit">Reserve</button>
    <button type="reset">Clear</button>
    <a href="/">Cancel</a>
</form>