<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCSVStickerRequest;
use App\Models\Sticker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StickerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $stickers = Sticker::query()
            ->when($request->sort, fn($q) => $q->orderBy($request->sort, $request->order === 'descending' ? 'desc' : 'asc'))
            ->orderByDesc('id')
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return Inertia::render('Sticker/Index', [
            'stickers' => $stickers,
            ...$request->all()
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sticker $sticker): void
    {
        $sticker->delete();
    }


    /**
     * @param UploadCSVStickerRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadCSVStickerRequest $request): RedirectResponse
    {
        // Логика должно быть в сервисе, а не в контроллерах

        $file = $request->file('file');

        $fileContents = str_replace('"', '', file($file->getPathname()));
        $newData = [];

        foreach ($fileContents as $key => $line) {
            $data = explode(';', $line);


            if ($key === 0 || !$data[0]) {
                continue;
            }

            $newData[] = [
                'code' => $data[0],
                'name' => $data[1] ?: null,
                'level_1' => $data[2] ?: null,
                'level_2' => $data[3] ?: null,
                'level_3' => $data[4] ?: null,
                'price' => $data[5] ?: null,
                'price_2' => $data[6] ?: null,
                'count' => $data[7] ?: null,
                'property' => $data[8] ?: null,
                'shop' => $data[9] ?: null,
                'unit' => $data[10] ?: null,
                'image' => $data[11] ?: null,
                'is_home' => $data[12] ?: false,
                'description' => trim($data[13]) ?: null,
            ];
//            logger(4444444, [$data[0]]);
        }


        Sticker::upsert($newData, ['code']);

        return redirect()->route('stickers.index');
    }
}
