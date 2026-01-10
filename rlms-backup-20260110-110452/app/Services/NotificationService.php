<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationService
{
    /**
     * Send reservation notification to user.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendReservationNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'created' => 'Your reservation request has been submitted and is pending approval.',
            'approved' => 'Your reservation has been approved.',
            'rejected' => 'Your reservation has been rejected.',
            'cancelled' => 'Your reservation has been cancelled.',
            'completed' => 'Your reservation has been completed.',
        ];

        $this->createNotification($user, [
            'type' => 'reservation',
            'action' => $type,
            'title' => 'Reservation ' . ucfirst($type),
            'message' => $messages[$type] ?? 'Reservation status updated.',
            'data' => $data,
        ]);
    }

    /**
     * Send material notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendMaterialNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'status_changed' => 'Material status has been updated.',
            'maintenance_scheduled' => 'Maintenance has been scheduled for a material.',
            'low_stock' => 'Material stock is running low.',
        ];

        $this->createNotification($user, [
            'type' => 'material',
            'action' => $type,
            'title' => 'Material Update',
            'message' => $messages[$type] ?? 'Material update.',
            'data' => $data,
        ]);
    }

    /**
     * Send project notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendProjectNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'added_to_project' => 'You have been added to a project.',
            'removed_from_project' => 'You have been removed from a project.',
            'role_changed' => 'Your role in the project has been changed.',
            'project_updated' => 'Project details have been updated.',
            'project_archived' => 'Project has been archived.',
        ];

        $this->createNotification($user, [
            'type' => 'project',
            'action' => $type,
            'title' => 'Project Update',
            'message' => $messages[$type] ?? 'Project update.',
            'data' => $data,
        ]);
    }

    /**
     * Send experiment notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendExperimentNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'created' => 'A new experiment has been added to your project.',
            'updated' => 'An experiment has been updated.',
            'commented' => 'Someone commented on an experiment.',
            'deleted' => 'An experiment has been deleted.',
        ];

        $this->createNotification($user, [
            'type' => 'experiment',
            'action' => $type,
            'title' => 'Experiment Update',
            'message' => $messages[$type] ?? 'Experiment update.',
            'data' => $data,
        ]);
    }

    /**
     * Send event notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendEventNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'created' => 'A new event has been created.',
            'updated' => 'Event details have been updated.',
            'cancelled' => 'An event has been cancelled.',
            'reminder' => 'Reminder: You have an upcoming event.',
            'registration_confirmed' => 'Your event registration has been confirmed.',
        ];

        $this->createNotification($user, [
            'type' => 'event',
            'action' => $type,
            'title' => 'Event Update',
            'message' => $messages[$type] ?? 'Event update.',
            'data' => $data,
        ]);
    }

    /**
     * Send maintenance notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendMaintenanceNotification(User $user, string $type, array $data): void
    {
        $messages = [
            'scheduled' => 'Maintenance has been scheduled.',
            'started' => 'Maintenance has started.',
            'completed' => 'Maintenance has been completed.',
            'overdue' => 'Maintenance is overdue.',
            'assigned' => 'You have been assigned to a maintenance task.',
        ];

        $this->createNotification($user, [
            'type' => 'maintenance',
            'action' => $type,
            'title' => 'Maintenance Update',
            'message' => $messages[$type] ?? 'Maintenance update.',
            'data' => $data,
        ]);
    }

    /**
     * Send user account notification.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     * @return void
     */
    public function sendUserNotification(User $user, string $type, array $data = []): void
    {
        $messages = [
            'approved' => 'Your account has been approved. You can now log in.',
            'rejected' => 'Your account registration has been rejected.',
            'suspended' => 'Your account has been suspended.',
            'role_changed' => 'Your role has been updated.',
            'welcome' => 'Welcome to the Research Laboratory Management System!',
        ];

        $this->createNotification($user, [
            'type' => 'user',
            'action' => $type,
            'title' => 'Account Update',
            'message' => $messages[$type] ?? 'Account update.',
            'data' => $data,
        ]);
    }

    /**
     * Create a database notification.
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    private function createNotification(User $user, array $data): void
    {
        $user->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\\Notifications\\GeneralNotification',
            'data' => $data,
            'read_at' => null,
        ]);
    }

    /**
     * Mark notification as read.
     *
     * @param string $notificationId
     * @param User $user
     * @return bool
     */
    public function markAsRead(string $notificationId, User $user): bool
    {
        $notification = $user->notifications()->find($notificationId);

        if (!$notification) {
            return false;
        }

        $notification->markAsRead();
        return true;
    }

    /**
     * Mark all notifications as read for a user.
     *
     * @param User $user
     * @return int Number of notifications marked as read
     */
    public function markAllAsRead(User $user): int
    {
        return $user->unreadNotifications()->update(['read_at' => now()]);
    }

    /**
     * Delete notification.
     *
     * @param string $notificationId
     * @param User $user
     * @return bool
     */
    public function deleteNotification(string $notificationId, User $user): bool
    {
        $notification = $user->notifications()->find($notificationId);

        if (!$notification) {
            return false;
        }

        $notification->delete();
        return true;
    }

    /**
     * Get unread notifications for a user.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getUnreadNotifications(User $user, int $limit = 10)
    {
        return $user->unreadNotifications()->limit($limit)->get();
    }

    /**
     * Get all notifications for a user.
     *
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getAllNotifications(User $user, int $limit = 50)
    {
        return $user->notifications()->limit($limit)->get();
    }

    /**
     * Get unread notification count.
     *
     * @param User $user
     * @return int
     */
    public function getUnreadCount(User $user): int
    {
        return $user->unreadNotifications()->count();
    }

    /**
     * Notify project members about an update.
     *
     * @param \App\Models\Project $project
     * @param string $type
     * @param array $data
     * @param User|null $excludeUser
     * @return void
     */
    public function notifyProjectMembers(\App\Models\Project $project, string $type, array $data, ?User $excludeUser = null): void
    {
        $members = $project->users;

        foreach ($members as $member) {
            if ($excludeUser && $member->id === $excludeUser->id) {
                continue;
            }

            $this->sendProjectNotification($member, $type, $data);
        }
    }

    /**
     * Notify admins and material managers.
     *
     * @param string $type
     * @param array $data
     * @return void
     */
    public function notifyManagers(string $type, array $data): void
    {
        $managers = User::role(['admin', 'material_manager'])->get();

        foreach ($managers as $manager) {
            $this->sendMaterialNotification($manager, $type, $data);
        }
    }

    /**
     * Send event reminders to attendees.
     *
     * @param \App\Models\Event $event
     * @return int Number of reminders sent
     */
    public function sendEventReminders(\App\Models\Event $event): int
    {
        $attendees = $event->confirmedAttendees;
        $count = 0;

        foreach ($attendees as $attendee) {
            $this->sendEventNotification($attendee, 'reminder', [
                'event_id' => $event->id,
                'event_title' => $event->title,
                'event_date' => $event->event_date->format('Y-m-d'),
                'event_time' => $event->event_time,
                'location' => $event->location,
            ]);
            $count++;
        }

        return $count;
    }
}
