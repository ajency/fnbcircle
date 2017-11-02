<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationQueue extends Model
{
    protected $table    = "notification_queue";


    public function getTemplateDataAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setTemplateDataAttribute( $value ) { 
		$this->attributes['template_data'] = serialize( $value );

	}

	public function getToAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setToAttribute( $value ) { 
		$this->attributes['to'] = serialize( $value );

	}

	public function getCcAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setCcAttribute( $value ) { 
		$this->attributes['cc'] = serialize( $value );

	}

	public function getBccAttribute( $value ) { 
        $value = unserialize( $value );
         
        return $value;
    }

	public function setBccAttribute( $value ) { 
		$this->attributes['bcc'] = serialize( $value );

	}
}
