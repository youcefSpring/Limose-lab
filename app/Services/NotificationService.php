<?php

namespace App\Services;

use App\Models\User;
use App\Models\Researcher;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EquipmentReservation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Notify admins of new researcher registration.
     */
    public function notifyAdminsOfNewResearcher(Researcher $researcher): void
    {
        $admins = User::where('role', 'admin')->where('status', 'active')->get();

        foreach ($admins as $admin) {
            // Send email notification
            $this->sendEmail($admin->email, 'تسجيل باحث جديد', [
                'subject' => 'تسجيل باحث جديد يتطلب الموافقة',
                'body' => "تم تسجيل باحث جديد: {$researcher->full_name}",
                'action_url' => url("/admin/researchers/{$researcher->id}"),
            ]);
        }

        \Log::info("Admin notification sent for new researcher: {$researcher->id}");
    }

    /**
     * Notify admins of new project submission.
     */
    public function notifyAdminsOfNewProject(Project $project): void
    {
        $admins = User::where('role', 'admin')->where('status', 'active')->get();

        foreach ($admins as $admin) {
            $this->sendEmail($admin->email, 'مشروع جديد يتطلب الموافقة', [
                'subject' => 'مشروع بحثي جديد يتطلب الموافقة',
                'body' => "تم إرسال مشروع جديد: {$project->getTitle()}",
                'leader' => $project->leader->full_name,
                'action_url' => url("/admin/projects/{$project->id}"),
            ]);
        }

        \Log::info("Admin notification sent for new project: {$project->id}");
    }

    /**
     * Notify project status change.
     */
    public function notifyProjectStatusChange(Project $project, string $oldStatus): void
    {
        $teamMembers = $project->members()->with('user')->get();

        foreach ($teamMembers as $member) {
            if ($member->user && $member->user->isActive()) {
                $statusMessage = match ($project->status) {
                    'active' => 'تم قبول المشروع وتفعيله',
                    'completed' => 'تم إكمال المشروع',
                    'suspended' => 'تم تعليق المشروع',
                    default => "تم تغيير حالة المشروع إلى {$project->status}",
                };

                $this->sendEmail($member->user->email, 'تحديث حالة المشروع', [
                    'subject' => "تحديث حالة المشروع: {$project->getTitle()}",
                    'body' => $statusMessage,
                    'old_status' => $oldStatus,
                    'new_status' => $project->status,
                    'action_url' => url("/projects/{$project->id}"),
                ]);
            }
        }

        \Log::info("Project status change notification sent for project: {$project->id}");
    }

    /**
     * Notify researcher added to project.
     */
    public function notifyResearcherAddedToProject(Researcher $researcher, Project $project): void
    {
        if ($researcher->user && $researcher->user->isActive()) {
            $this->sendEmail($researcher->user->email, 'إضافة إلى مشروع', [
                'subject' => 'تمت إضافتك إلى مشروع بحثي',
                'body' => "تمت إضافتك إلى المشروع: {$project->getTitle()}",
                'project_leader' => $project->leader->full_name,
                'action_url' => url("/projects/{$project->id}"),
            ]);
        }

        \Log::info("Researcher added to project notification sent: {$researcher->id} -> {$project->id}");
    }

    /**
     * Notify researcher removed from project.
     */
    public function notifyResearcherRemovedFromProject(Researcher $researcher, Project $project): void
    {
        if ($researcher->user && $researcher->user->isActive()) {
            $this->sendEmail($researcher->user->email, 'إزالة من مشروع', [
                'subject' => 'تم إزالتك من مشروع بحثي',
                'body' => "تم إزالتك من المشروع: {$project->getTitle()}",
                'project_leader' => $project->leader->full_name,
            ]);
        }

        \Log::info("Researcher removed from project notification sent: {$researcher->id} -> {$project->id}");
    }

    /**
     * Notify publication published.
     */
    public function notifyPublicationPublished(Publication $publication): void
    {
        $authors = $publication->authorResearchers()->with('user')->get();

        foreach ($authors as $author) {
            if ($author->user && $author->user->isActive()) {
                $this->sendEmail($author->user->email, 'نشر منشور', [
                    'subject' => 'تم نشر منشور علمي',
                    'body' => "تم نشر المنشور: {$publication->title}",
                    'journal' => $publication->journal ?? $publication->conference,
                    'year' => $publication->publication_year,
                    'action_url' => url("/publications/{$publication->id}"),
                ]);
            }
        }

        \Log::info("Publication published notification sent for: {$publication->id}");
    }

    /**
     * Notify admins of new equipment reservation.
     */
    public function notifyAdminsOfNewReservation(EquipmentReservation $reservation): void
    {
        $admins = User::whereIn('role', ['admin', 'lab_manager'])->where('status', 'active')->get();

        foreach ($admins as $admin) {
            $this->sendEmail($admin->email, 'حجز معدة جديد', [
                'subject' => 'طلب حجز معدة جديد',
                'body' => "طلب حجز جديد للمعدة: {$reservation->equipment->getName()}",
                'researcher' => $reservation->researcher->full_name,
                'start_date' => $reservation->start_datetime->format('Y-m-d H:i'),
                'end_date' => $reservation->end_datetime->format('Y-m-d H:i'),
                'action_url' => url("/admin/reservations/{$reservation->id}"),
            ]);
        }

        \Log::info("Admin notification sent for new reservation: {$reservation->id}");
    }

    /**
     * Notify reservation approved.
     */
    public function notifyReservationApproved(EquipmentReservation $reservation): void
    {
        if ($reservation->researcher->user && $reservation->researcher->user->isActive()) {
            $this->sendEmail($reservation->researcher->user->email, 'موافقة على الحجز', [
                'subject' => 'تم قبول طلب حجز المعدة',
                'body' => "تم قبول طلب حجز المعدة: {$reservation->equipment->getName()}",
                'start_date' => $reservation->start_datetime->format('Y-m-d H:i'),
                'end_date' => $reservation->end_datetime->format('Y-m-d H:i'),
                'action_url' => url("/reservations/{$reservation->id}"),
            ]);
        }

        \Log::info("Reservation approved notification sent: {$reservation->id}");
    }

    /**
     * Notify reservation rejected.
     */
    public function notifyReservationRejected(EquipmentReservation $reservation, string $reason): void
    {
        if ($reservation->researcher->user && $reservation->researcher->user->isActive()) {
            $this->sendEmail($reservation->researcher->user->email, 'رفض الحجز', [
                'subject' => 'تم رفض طلب حجز المعدة',
                'body' => "تم رفض طلب حجز المعدة: {$reservation->equipment->getName()}",
                'reason' => $reason,
                'start_date' => $reservation->start_datetime->format('Y-m-d H:i'),
                'end_date' => $reservation->end_datetime->format('Y-m-d H:i'),
            ]);
        }

        \Log::info("Reservation rejected notification sent: {$reservation->id}");
    }

    /**
     * Notify event published.
     */
    public function notifyEventPublished(Event $event): void
    {
        // Notify all active researchers about new event
        $researchers = User::where('role', 'researcher')->where('status', 'active')->get();

        foreach ($researchers as $researcher) {
            $this->sendEmail($researcher->email, 'حدث جديد', [
                'subject' => 'حدث علمي جديد',
                'body' => "تم نشر حدث جديد: {$event->getTitle()}",
                'event_type' => $event->type,
                'start_date' => $event->start_date->format('Y-m-d'),
                'location' => $event->getLocation(),
                'action_url' => url("/events/{$event->id}"),
            ]);
        }

        \Log::info("Event published notification sent for: {$event->id}");
    }

    /**
     * Notify event updated.
     */
    public function notifyEventUpdated(Event $event): void
    {
        $participants = $event->registrations()->with('user')->get();

        foreach ($participants as $registration) {
            if ($registration->user && $registration->user->isActive()) {
                $this->sendEmail($registration->user->email, 'تحديث الحدث', [
                    'subject' => "تحديث في الحدث: {$event->getTitle()}",
                    'body' => 'تم تحديث تفاصيل الحدث المسجل فيه',
                    'start_date' => $event->start_date->format('Y-m-d'),
                    'location' => $event->getLocation(),
                    'action_url' => url("/events/{$event->id}"),
                ]);
            }
        }

        \Log::info("Event updated notification sent for: {$event->id}");
    }

    /**
     * Notify event started.
     */
    public function notifyEventStarted(Event $event): void
    {
        $participants = $event->registrations()->confirmed()->with('user')->get();

        foreach ($participants as $registration) {
            if ($registration->user && $registration->user->isActive()) {
                $this->sendEmail($registration->user->email, 'بداية الحدث', [
                    'subject' => "بدء الحدث: {$event->getTitle()}",
                    'body' => 'بدأ الحدث المسجل فيه',
                    'location' => $event->getLocation(),
                    'action_url' => url("/events/{$event->id}"),
                ]);
            }
        }

        \Log::info("Event started notification sent for: {$event->id}");
    }

    /**
     * Notify event cancelled.
     */
    public function notifyEventCancelled(Event $event): void
    {
        $participants = $event->registrations()->with('user')->get();

        foreach ($participants as $registration) {
            if ($registration->user && $registration->user->isActive()) {
                $this->sendEmail($registration->user->email, 'إلغاء الحدث', [
                    'subject' => "تم إلغاء الحدث: {$event->getTitle()}",
                    'body' => 'تم إلغاء الحدث المسجل فيه',
                    'start_date' => $event->start_date->format('Y-m-d'),
                ]);
            }
        }

        \Log::info("Event cancelled notification sent for: {$event->id}");
    }

    /**
     * Notify new event registration.
     */
    public function notifyEventRegistration(EventRegistration $registration): void
    {
        $organizer = $registration->event->organizer;

        if ($organizer && $organizer->isActive()) {
            $this->sendEmail($organizer->email, 'تسجيل جديد في الحدث', [
                'subject' => "تسجيل جديد في الحدث: {$registration->event->getTitle()}",
                'body' => "تم تسجيل مشارك جديد: {$registration->user->name}",
                'event_date' => $registration->event->start_date->format('Y-m-d'),
                'action_url' => url("/events/{$registration->event->id}/participants"),
            ]);
        }

        \Log::info("Event registration notification sent for: {$registration->id}");
    }

    /**
     * Send registration confirmation.
     */
    public function sendRegistrationConfirmation(EventRegistration $registration): void
    {
        if ($registration->user && $registration->user->isActive()) {
            $this->sendEmail($registration->user->email, 'تأكيد التسجيل', [
                'subject' => "تأكيد التسجيل في الحدث: {$registration->event->getTitle()}",
                'body' => 'تم تسجيلك بنجاح في الحدث',
                'event_date' => $registration->event->start_date->format('Y-m-d'),
                'location' => $registration->event->getLocation(),
                'action_url' => url("/events/{$registration->event->id}"),
            ]);
        }

        \Log::info("Registration confirmation sent for: {$registration->id}");
    }

    /**
     * Notify registration cancelled.
     */
    public function notifyRegistrationCancelled(EventRegistration $registration): void
    {
        $organizer = $registration->event->organizer;

        if ($organizer && $organizer->isActive()) {
            $this->sendEmail($organizer->email, 'إلغاء تسجيل', [
                'subject' => "إلغاء تسجيل في الحدث: {$registration->event->getTitle()}",
                'body' => "تم إلغاء تسجيل المشارك: {$registration->user->name}",
                'event_date' => $registration->event->start_date->format('Y-m-d'),
            ]);
        }

        \Log::info("Registration cancellation notification sent for: {$registration->id}");
    }

    /**
     * Send email notification.
     */
    private function sendEmail(string $email, string $subject, array $data): void
    {
        try {
            // In a real implementation, you would use Laravel's Mail system
            // with proper email templates and queue processing
            \Log::info("Email notification sent", [
                'to' => $email,
                'subject' => $subject,
                'data' => $data,
            ]);

            // Example of how this would work with actual Mail implementation:
            /*
            Mail::send('emails.notification', $data, function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });
            */
        } catch (\Exception $e) {
            \Log::error("Failed to send email notification", [
                'to' => $email,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send push notification (for mobile apps).
     */
    private function sendPushNotification(User $user, string $title, string $body, array $data = []): void
    {
        try {
            // This would integrate with Firebase Cloud Messaging
            // or another push notification service
            \Log::info("Push notification sent", [
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            \Log::error("Failed to send push notification", [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Create in-app notification.
     */
    private function createInAppNotification(User $user, string $type, string $title, string $message, array $data = []): void
    {
        try {
            // This would create a record in a notifications table
            // for display in the web/mobile app interface
            \Log::info("In-app notification created", [
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            \Log::error("Failed to create in-app notification", [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}