<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use App\Http\Requests\TerminalRequest;

class TerminalController extends Controller
{
    /**
     * Get all terminals.
     */
    public function getAllTerminals()
    {
        try {
            $terminals = Terminal::all();
            return response()->json(["terminals" => $terminals], 200);
        } catch (\Throwable $e) {
            return response()->json(["error" => "Failed to fetch terminals", "message" => $e->getMessage()], 500);
        }
    }

    /**
     * Get a specific terminal by ID.
     */
    public function getTerminalById($id)
    {
        try {
            $terminal = Terminal::findOrFail($id);
            return response()->json($terminal, 200);
        } catch (\Throwable $e) {
            return response()->json(["error" => "Terminal not found", "message" => $e->getMessage()], 404);
        }
    }

    /**
     * Create a new terminal.
     */
    public function createTerminal(TerminalRequest $request)
    {
        try {
            $data = $request->validated();
            $terminal = Terminal::create($data);

            return response()->json([
                "message" => "Terminal created successfully",
                "terminal" => $terminal
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                "error" => "Failed to create terminal",
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Update an existing terminal by ID.
     */
    public function updateTerminal(TerminalRequest $request, $id)
    {
        try {
            $terminal = Terminal::findOrFail($id);
            $data = $request->validated();
            $terminal->update($data);

            return response()->json([
                "message" => "Terminal updated successfully",
                "terminal" => $terminal
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                "error" => "Failed to update terminal",
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete a terminal by ID.
     */
    public function deleteTerminal($id)
    {
        try {
            $terminal = Terminal::findOrFail($id);
            $terminal->delete();

            return response()->json(["message" => "Terminal deleted successfully"], 200);
        } catch (\Throwable $e) {
            return response()->json([
                "error" => "Failed to delete terminal",
                "message" => $e->getMessage()
            ], 400);
        }
    }
}