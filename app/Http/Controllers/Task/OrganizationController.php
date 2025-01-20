<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class OrganizationController extends Controller
{
    // Create a new organization
    public function createOrganization(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'logo' => 'nullable|string',
                'teams' => 'nullable|array',
            ]);

            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            $organization = Organization::create([
                'name' => $validated['name'],
                'logo' => $validated['logo'] ?? null,
                'teams' => $validated['teams'] ?? [],
            ]);

            if ($organization) {
                $user->update(['organization_id' => $organization->id]);

                return response()->json([
                    'status' => true,
                    'message' => 'Organization has been created.',
                    'data' => $organization
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => 'Could not create organization',
            ], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get all organizations
    public function getOrganizations()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            $organizations = Organization::orderBy('id', 'desc')->get();

            return response()->json([
                'status' => true,
                'message' => 'List of all organizations',
                'data' => $organizations,
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get organization by ID
    public function getOrganizationById($id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            $organization = Organization::with('members')->find($id);

            if ($organization) {
                return response()->json([
                    'status' => true,
                    'message' => 'Organization data',
                    'data' => $organization,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Organization not found',
            ], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Update user team
    public function updateUserTeam(Request $request)
    {
        try {
            $validated = $request->validate([
                'team' => 'required|string|max:255',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            $user->update(['team' => $validated['team']]);

            $updatedUser = User::with('organization')->find($user->id);

            return response()->json([
                'status' => true,
                'message' => 'User team updated successfully.',
                'data' => $updatedUser,
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Invite members via email
    public function inviteMembers(Request $request)
    {
        try {
            $validated = $request->validate([
                'emails' => 'required|array',
                'emails.*' => 'email',
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            foreach ($validated['emails'] as $email) {
                // Simulate sending email (you would integrate your mail service here)
                // For now, we use Laravel's Mail facade or an external service.
                // You can use Mailgun, SendGrid, or any service you prefer.
                // For example:
                // Mail::to($email)->send(new InvitationMail($user));

                // Mocking the email sending process
                Log::info("Invitation sent to: $email");
            }

            return response()->json([
                'status' => true,
                'message' => 'Invitation sent!',
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // List members of an organization
    public function listMembers($organizationId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and Sign in again.'
                ], 401);
            }

            $users = User::where('organization_id', $organizationId)
                ->get(['id', 'name', 'email', 'team']); // Adjust the attributes as needed

            if ($users->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Users in the organization',
                    'data' => $users,
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Users not found',
            ], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}


/**
 * {
  "name": "Tech Corp",
  "logo": "https://example.com/logo.png",
  "teams": ["Engineering", "Marketing"]
}

{
  "status": true,
  "message": "List of all organizations",
  "data": [
    {
      "id": 1,
      "name": "Tech Corp",
      "logo": "https://example.com/logo.png",
      "teams": ["Engineering", "Marketing"],
      "created_at": "2024-11-12T12:34:56",
      "updated_at": "2024-11-12T12:34:56"
    }
  ]
}
 
{
  "emails": [
    "john.doe@example.com",
    "jane.smith@example.com"
  ]
}

 */