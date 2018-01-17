<?php 

namespace Tuiter\Core\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    public function validate($input)
    {
        return $input 
            ? is_null(app('user.repository')->getByEmail($input))
            : true ;
    }
}