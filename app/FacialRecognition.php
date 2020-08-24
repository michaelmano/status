<?php

namespace App;

use Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Process\Process;
use Illuminate\Database\Eloquent\Model;

class FacialRecognition extends Model
{
    public $errors = [];
    public $predictions = [];
    protected $dates = ['date'];
    protected $image_name = 'raw.png';
    protected $appends = [
        'id',
        'image_url',
        'errors',
        'predictions'
    ];

    public function __construct($image = null)
    {
        parent::__construct();

        if ($image != null) {
            $this->date = Carbon::now()->timestamp;
            $file_name = "{$this->folder_name}/{$this->image_name}";
            Storage::disk('public')
                ->put($file_name, self::decodeImage($image));
        }
    }

    public function getErrorsAttribute()
    {
        return $this->errors;
    }

    public function getPredictionsAttribute()
    {
        return $this->predictions;
    }

    public function getIdAttribute()
    {
        return Crypt::encryptString($this->date->timestamp);
    }

    public static function find($id)
    {
        if (isset($id)) {
            $facerec = new Self();
            $facerec->date = Crypt::decryptString($id);

            return $facerec;
        }
    }

    public function getDateAttribute()
    {
        return $this->date;
    }

    public function getFolderNameAttribute()
    {
        return "{$this->date->toDateString()}/{$this->date->timestamp}";
    }

    public function getImageUrlAttribute()
    {
        return Storage::url("{$this->folder_name}/{$this->image_name}");
    }

    public function getImageAbsolutePathAttribute()
    {
        return storage_path('app/public')."/{$this->folder_name}/{$this->image_name}";
    }

    public function setDateAttribute($timestamp)
    {
        $this->date = Carbon::createFromTimestamp($timestamp);

        return $this;
    }

    public function confirmPredictions($predictions)
    {
        $this->predictions = $predictions;

        Storage::disk('public')
            ->delete("{$this->folder_name}/{$this->image_name}");

        collect($predictions)->each(function ($prediction) {
            $name = $this->formatName($prediction[0]);
            $img_name = "{$this->training_path}/{$name}/{$this->date->timestamp}.png";
            $avatar = $prediction[1];
            Storage::disk('training_data')
                ->put($img_name, self::decodeImage($avatar));
        });

        return $this;
    }

    public function makePrediction()
    {
        $process = new Process(config('app.facial_recognition_command')." ".$this->image_absolute_path);
        $process->run();

        if (!$process->isSuccessful()) {
            $error = "There was an issue with the facial detection API";
            $this->errors[] = (object) ['message' => $error];
        }

        $response = json_decode($process->getOutput(), true);

        if (isset($response['error'])) {
            collect($response['error'])->each(function ($error) {
                $this->errors[] = (object) ['message' => $error];
            });
        }
        
        if (isset($response['predictions'])) {
            if (count($response['predictions']) <= 0) {
                $this->errors[] = (object) ['message' => 'No predictions were returned'];
            } else {
                $this->predictions = $response['predictions'];
            }
        }

        return $this;
    }
    
    private static function decodeImage($image)
    {
        return base64_decode(
            preg_replace('#^data:image/\w+;base64,#i', '', $image)
        );
    }

    private function formatName($value)
    {
        return str_replace(' ', '_', strtolower($value));
    }

    public static function cleanupTempDirectory()
    {
        return Storage::deleteDirectory("/public/facial_recognition/tmp");
    }
}
