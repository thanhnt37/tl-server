<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'wildcard',
        'name',
        'description',
        'file_name',
        'link',
        'type',
        'mode_play',
        'sub_link',
        'cover_image_id',
        'view',
        'play',
        'vote',
        'author_id',
        'publish_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['publish_at', 'deleted_at'];

    protected $presenter = \App\Presenters\SongPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SongObserver);
    }

    // Relations
    public function coverImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'cover_image_id');
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\Author::class, 'author_id', 'id');
    }

    public function albums()
    {
        return $this->belongsToMany(\App\Models\Album::class, AlbumSong::getTableName(), 'song_id', 'album_id');
    }

    public function genres()
    {
        return $this->belongsToMany(\App\Models\Genre::class, GenreSong::getTableName(), 'song_id', 'genre_id');
    }

    public function singers()
    {
        return $this->belongsToMany(\App\Models\Singer::class, SingerSong::getTableName(), 'song_id', 'singer_id');
    }

    public function getUrl()
    {
        if( empty($this->file_name) || $this->file_name == '' ) {
            return '';
        }

        $songName = $this->file_name;
        $songID = substr($songName, 0, -4);

        //vi co 2 o HDD chua du lieu bai hat, moi id lai nam tren HDD khac nhau nen phai co doan code nay
        if ($songID <= 8899)
            $path = '/data2/'.$songName;

        if ($songID >= 8900 and $songID <= 9999)
            $path = '/'.$songName;

        if ($songID >= 10000 and $songID <= 20630)
            $path = '/data2/'.$songName;

        if ($songID >= 20631)
            $path = '/'.$songName;
        
        //lay link bai hat
        $secret = '123host'; // Khoa bao mat
        $url_base = 'http://103.255.239.200';

        $expire = time() +  10*60*1000;
        $md5 = base64_encode(md5($secret . $path . $expire, true));
        $md5 = strtr($md5, '+/', '-_');
        $md5 = str_replace('=', '', $md5);

        return $url_base.$path."?key=".$md5."&e=".$expire;
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'wildcard'    => $this->wildcard,
            'name'        => $this->name,
            'description' => $this->description,
            'link'        => $this->getUrl(),
            'type'        => pathinfo($this->file_name, PATHINFO_EXTENSION),
            'mode_play'   => intval($this->mode_play),
            'sub_link'    => $this->sub_link,
            'cover_image' => !empty($this->coverImage) ? $this->coverImage->present()->url : 'http://placehold.it/640x480?text=No%20Image',
            'view'        => intval($this->view),
            'play'        => intval($this->play),
            'vote'        => intval($this->vote),
            'author'      => isset($this->author->name) ? $this->author->name : 'Unknown',
            'singers'     => isset($this->singers[0]['name']) ? $this->singers[0]->toAPIArray() : null,
            'publish_at'  => date_format($this->publish_at, 'Y-m-d H:i:s'),
        ];
    }

}
