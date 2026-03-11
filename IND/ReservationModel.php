<?php
/*
SEHS4517 Web Application Development and Management
Individual Assignment
Scenario: Drone Training Center Equipment Rental Portal
Full Name: LIU SHA
Student ID: 24810144S
*/

class ReservationModel
{
    /**
     * Validate whether the reservation time is between 24 and 72 hours in advance.
     *
     * @param string $date Format: YYYY-MM-DD
     * @param string $time Format: HH:MM
     * @return array{
     *   status: string,
     *   valid: bool,
     *   message: string,
     *   hours: float
     * }
     */
    public function validateReservation(string $date, string $time): array
    {
        $reservationTimestamp = strtotime(trim($date . ' ' . $time));
        $currentTimestamp = time();

        if ($reservationTimestamp === false) {
            return [
                'status' => 'Error',
                'valid' => false,
                'message' => 'The reservation date or time is invalid.',
                'hours' => 0
            ];
        }

        $secondsDifference = $reservationTimestamp - $currentTimestamp;
        $hoursDifference = $secondsDifference / 3600;

        if ($hoursDifference >= 24 && $hoursDifference <= 72) {
            return [
                'status' => 'Success',
                'valid' => true,
                'message' => 'Your reservation request has been accepted successfully.',
                'hours' => $hoursDifference
            ];
        }

        if ($hoursDifference < 24) {
            return [
                'status' => 'Error',
                'valid' => false,
                'message' => 'The reservation is too soon. Please make a reservation at least 24 hours in advance.',
                'hours' => $hoursDifference
            ];
        }

        return [
            'status' => 'Error',
            'valid' => false,
            'message' => 'The reservation is too far in advance. Please make a reservation within 72 hours.',
            'hours' => $hoursDifference
        ];
    }
}