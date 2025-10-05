<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();
        $users = User::all();

        foreach ($events as $event) {
            // Determine number of registrations based on event status
            $maxRegistrations = $event->max_participants;
            $numRegistrations = $this->getRegistrationCount($event->status, $maxRegistrations);

            // Select random users for registration
            $selectedUsers = $users->random(min($numRegistrations, $users->count()));

            foreach ($selectedUsers as $index => $user) {
                $registrationDate = $this->generateRegistrationDate($event);
                $status = $this->getRegistrationStatus($event, $registrationDate);

                DB::table('event_registrations')->insert([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'registration_date' => $registrationDate,
                    'status' => $status,
                    'attendance_status' => $this->getAttendanceStatus($event, $status),
                    'payment_status' => $this->getPaymentStatus($event->registration_fee, $status),
                    'payment_amount' => $event->registration_fee,
                    'special_requirements' => $this->generateSpecialRequirements(),
                    'notes' => $this->generateRegistrationNotes($user, $event),
                    'confirmation_sent' => in_array($status, ['confirmed', 'attended']),
                    'reminder_sent' => in_array($status, ['confirmed', 'attended']),
                    'certificate_issued' => $this->shouldIssueCertificate($event, $status),
                    'feedback_rating' => $this->getFeedbackRating($event, $status),
                    'feedback_comments' => $this->generateFeedbackComments($event, $status),
                    'dietary_restrictions' => $this->generateDietaryRestrictions(),
                    'emergency_contact' => $this->generateEmergencyContact(),
                    'created_at' => $registrationDate,
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getRegistrationCount(string $eventStatus, int $maxParticipants): int
    {
        return match ($eventStatus) {
            'registration_open' => rand(5, intval($maxParticipants * 0.7)),
            'registration_closed' => rand(intval($maxParticipants * 0.8), $maxParticipants),
            'completed' => rand(intval($maxParticipants * 0.6), intval($maxParticipants * 0.9)),
            'cancelled' => rand(0, intval($maxParticipants * 0.3)),
            default => rand(0, intval($maxParticipants * 0.5)),
        };
    }

    private function generateRegistrationDate($event): string
    {
        $eventStart = new \DateTime($event->start_date);
        $registrationDeadline = new \DateTime($event->registration_deadline ?? $event->start_date);

        // Registration date should be between event creation and deadline
        $earliestDate = max(
            $eventStart->getTimestamp() - (60 * 24 * 60 * 60), // 60 days before event
            now()->subDays(90)->getTimestamp()
        );

        $latestDate = min(
            $registrationDeadline->getTimestamp(),
            now()->getTimestamp()
        );

        $randomTimestamp = rand($earliestDate, $latestDate);
        return (new \DateTime())->setTimestamp($randomTimestamp)->format('Y-m-d H:i:s');
    }

    private function getRegistrationStatus($event, string $registrationDate): string
    {
        $eventStart = new \DateTime($event->start_date);
        $eventEnd = new \DateTime($event->end_date);
        $now = now();

        // If event is cancelled
        if ($event->status === 'cancelled') {
            return rand(0, 1) ? 'cancelled' : 'confirmed';
        }

        // If event has ended
        if ($eventEnd < $now) {
            $statuses = ['attended', 'no_show', 'cancelled'];
            $weights = [70, 20, 10]; // 70% attended, 20% no-show, 10% cancelled
            return $this->weightedRandomChoice($statuses, $weights);
        }

        // If event is in progress
        if ($eventStart <= $now && $eventEnd >= $now) {
            return rand(0, 8) ? 'confirmed' : 'no_show';
        }

        // Future events
        return rand(0, 9) ? 'confirmed' : 'pending';
    }

    private function getAttendanceStatus($event, string $registrationStatus): ?string
    {
        $eventEnd = new \DateTime($event->end_date);
        $now = now();

        // Only set attendance status for completed events
        if ($eventEnd >= $now) {
            return null;
        }

        return match ($registrationStatus) {
            'attended' => 'present',
            'no_show' => 'absent',
            'cancelled' => null,
            default => rand(0, 8) ? 'present' : 'absent'
        };
    }

    private function getPaymentStatus(float $fee, string $registrationStatus): string
    {
        if ($fee == 0) {
            return 'not_required';
        }

        return match ($registrationStatus) {
            'confirmed', 'attended' => 'paid',
            'cancelled' => rand(0, 1) ? 'refunded' : 'paid',
            'no_show' => 'paid',
            default => rand(0, 7) ? 'paid' : 'pending'
        };
    }

    private function generateSpecialRequirements(): ?string
    {
        $requirements = [
            'Wheelchair accessible seating',
            'Sign language interpreter',
            'Large print materials',
            'Quiet room access',
            'Early arrival requested',
            null, null, null, null, null // Most registrations have no special requirements
        ];

        return $requirements[array_rand($requirements)];
    }

    private function generateRegistrationNotes($user, $event): ?string
    {
        $notes = [
            "Looking forward to attending this {$event->type}",
            'First time attending this type of event',
            'Attending as part of professional development',
            'Interested in networking opportunities',
            'Hope to learn new techniques',
            null, null, null, null // Most registrations have no notes
        ];

        return $notes[array_rand($notes)];
    }

    private function shouldIssueCertificate($event, string $status): bool
    {
        return ($event->certification ?? false) &&
               in_array($status, ['attended']) &&
               rand(0, 9) < 9; // 90% chance if attended and event offers certification
    }

    private function getFeedbackRating($event, string $status): ?int
    {
        $eventEnd = new \DateTime($event->end_date);
        $now = now();

        // Only generate feedback for completed events where user attended
        if ($eventEnd >= $now || $status !== 'attended') {
            return null;
        }

        // Generate rating 1-5, weighted towards higher ratings
        $ratings = [1, 2, 3, 4, 5];
        $weights = [5, 10, 20, 35, 30]; // Weighted towards 4-5
        return $this->weightedRandomChoice($ratings, $weights);
    }

    private function generateFeedbackComments($event, string $status): ?string
    {
        $eventEnd = new \DateTime($event->end_date);
        $now = now();

        // Only generate feedback for completed events where user attended
        if ($eventEnd >= $now || $status !== 'attended') {
            return null;
        }

        // Only generate comments 30% of the time
        if (rand(0, 9) < 7) {
            return null;
        }

        $comments = [
            'Excellent content and well-organized event. Learned a lot!',
            'Great networking opportunities and knowledgeable speakers.',
            'Very informative sessions. Would recommend to colleagues.',
            'Good event overall, but could use more hands-on activities.',
            'Outstanding workshop with practical applications.',
            'Well-structured program with relevant topics.',
            'Enjoyed the interactive sessions and Q&A portions.',
            'Valuable information presented clearly and professionally.',
        ];

        return $comments[array_rand($comments)];
    }

    private function generateDietaryRestrictions(): ?string
    {
        $restrictions = [
            'Vegetarian',
            'Vegan',
            'Gluten-free',
            'Dairy-free',
            'Nut allergy',
            'Halal',
            'Kosher',
            null, null, null, null, null, null, null // Most people have no restrictions
        ];

        return $restrictions[array_rand($restrictions)];
    }

    private function generateEmergencyContact(): ?string
    {
        // Only 20% of registrations provide emergency contact
        if (rand(0, 4) !== 0) {
            return null;
        }

        $contacts = [
            'John Smith - +1-555-0123',
            'Mary Johnson - +1-555-0456',
            'David Wilson - +1-555-0789',
            'Sarah Brown - +1-555-0321',
            'Michael Davis - +1-555-0654',
        ];

        return $contacts[array_rand($contacts)];
    }

    private function weightedRandomChoice(array $choices, array $weights): mixed
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        $currentWeight = 0;
        foreach ($choices as $index => $choice) {
            $currentWeight += $weights[$index];
            if ($random <= $currentWeight) {
                return $choice;
            }
        }

        return $choices[0]; // Fallback
    }
}