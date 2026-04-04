<h1>Thank You for Reserving Your Game Session!</h1>

<p>Your adventure awaits!</p>

<p><strong>Email:</strong> {{ $reservation->member->email }}</p>
<p><strong>Date:</strong> {{ $reservation->reservation_date }}</p>
<p><strong>Time Slot:</strong> {{ $reservation->time_slot }}</p>
<p><strong>Table/Room:</strong> {{ $reservation->space->name }}</p>

<a href="/">OK</a>