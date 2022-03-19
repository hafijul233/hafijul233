<?php


namespace App\Services\Backend\Common;


use App\Abstracts\Service\Service;
use App\Supports\Constant;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Laravolt\Avatar\Facade as Avatar;
use function public_path;

class FileUploadService extends Service
{
    /**
     * @param string $name
     * @param string $extension
     * @return string|null
     * @throws Exception
     */
    public function createAvatarImageFromText(string $name, string $extension = 'jpg'): ?string
    {
        $fileName = $this->randomFileName($extension);

        $tmpPath = public_path('/media/tmp/');

        if (!is_dir($tmpPath))
            mkdir($tmpPath, '0777', true);

        $imageObject = Image::canvas(256, 256, '#ffffff');
        try {
            $imageObject = Avatar::create($name)->getImageObject();
        } catch (Exception $imageMakeException) {
            $imageObject = Image::make(Constant::USER_PROFILE_IMAGE);
            Log::error($imageMakeException->getMessage());
        } finally {
            try {
                if ($imageObject instanceof \Intervention\Image\Image) {
                    if ($imageObject->resize(256, 256)->save($tmpPath . $fileName, 80, $extension)) {
                        return $tmpPath . $fileName;
                    } else
                        return null;
                }

            } catch (Exception $imageSaveException) {
                Log::error($imageSaveException->getMessage());
                return null;
            }
        }

        return null;
    }

    /**
     * @param UploadedFile $file
     * @param string $extension
     * @return string|null
     */
    public function createAvatarImageFromInput(UploadedFile $file, string $extension = 'jpg'): ?string
    {
        $fileName = $this->randomFileName($extension);
        $tmpPath = public_path('/media/tmp/');
        $imageObject = Image::canvas(256, 256, '#ffffff');

        try {
            $imageObject = Image::make($file);
        } catch (Exception $imageMakeException) {
            $imageObject = Image::make('public/assets/images/favicon.ico');
            Log::error($imageMakeException->getMessage());
        } finally {
            try {
                if ($imageObject instanceof \Intervention\Image\Image) {
                    if ($imageObject->resize(256, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->crop(256, 256, 0, 0)
                        ->save($tmpPath . $fileName, 80, $extension))
                        return $tmpPath . $fileName;
                    else
                        return null;
                }

            } catch (Exception $imageSaveException) {
                Log::error($imageSaveException->getMessage());
                return null;
            }
        }

        return null;
    }

    /**
     * @param string $extension
     * @return string
     */
    public function randomFileName(string $extension = 'jpg'): string
    {
        return Str::random(32) . '.' . $extension;
    }
}
