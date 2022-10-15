<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Mail\NewMail;
use Approval\Models\Modification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->userRepository->getAllusers()
        ]);
    }

    public function store(array $request): JsonResponse
    {
        $request['uid'] = Str::orderedUuid();

        $emailAddress = auth()->user()->email;
        Mail::mailer('Kredi')
            ->to($emailAddress())
            ->send(new NewMail);

        return response()->json(
            [
                'data' => $this->userRepository->createuser($request)
            ],
            Response::HTTP_CREATED
        );
    }

    public function list()
    {
        return response()->json([
            'data' => $this->userRepository->getAllModification()
        ]);
    }

    public function show(object $request): JsonResponse
    {
        $userId = $request->route('id');

        return response()->json([
            'data' => $this->userRepository->getuserById($userId)
        ]);
    }

    public function approve(array $data, int $id)
    {
        $user = $data['user'];
        $comment = (!empty($data['comment'])) ? $data['comment'] : "Approved";
        $modification = Modification::where('id', $id)->first();

        if (!$modification) {
            return response()->json(['data' => 'No modification for this id'], 400);
        }

        try {
            $user->approve($modification, $comment);
            return response()->json(['data' => 'Approved successfully'], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function disapprove(array $data, int $id)
    {
        $user = $data['user'];
        $comment = (!empty($data['comment'])) ? $data['comment'] : "Disapproved";
        $modification = Modification::where('id', $id)->first();

        if (!$modification) {
            return response()->json(['data' => 'No modification for this id'], 400);
        }

        try {
            $user->disapprove($modification, $comment);
            return response()->json(['data' => 'Disapprove successfully'], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update(object $request): JsonResponse
    {
        $userId = $request->route('id');
        $userDetails = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->userRepository->updateuser($userId, $userDetails)
        ]);
    }

    public function destroy(object $request): JsonResponse
    {
        $userId = $request->route('id');
        $this->userRepository->deleteuser($userId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
