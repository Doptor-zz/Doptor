define(function(require) {
  var formname               = require('text!templates/snippet/formname.html')
  , prependedtext            = require('text!templates/snippet/prependedtext.html')
  , search                   = require('text!templates/snippet/searchinput.html')
  , textinput                = require('text!templates/snippet/textinput.html')
  , appendedcheckbox         = require('text!templates/snippet/appendedcheckbox.html')
  , appendedtext             = require('text!templates/snippet/appendedtext.html')
  , filebutton               = require('text!templates/snippet/filebutton.html')
  , button                   = require('text!templates/snippet/button.html')
  , buttondouble             = require('text!templates/snippet/buttondouble.html')
  , buttondropdown           = require('text!templates/snippet/buttondropdown.html')
  , multiplecheckboxes       = require('text!templates/snippet/multiplecheckboxes.html')
  , multiplecheckboxesinline = require('text!templates/snippet/multiplecheckboxesinline.html')
  , multipleradios           = require('text!templates/snippet/multipleradios.html')
  , multipleradiosinline     = require('text!templates/snippet/multipleradiosinline.html')
  , passwordinput            = require('text!templates/snippet/passwordinput.html')
  , prependedcheckbox        = require('text!templates/snippet/prependedcheckbox.html')
  , prependedtext            = require('text!templates/snippet/prependedtext.html')
  , searchinput              = require('text!templates/snippet/searchinput.html')
  , selectbasic              = require('text!templates/snippet/selectbasic.html')
  , selectmultiple           = require('text!templates/snippet/selectmultiple.html')
  , textarea                 = require('text!templates/snippet/textarea.html')
  , textinput                = require('text!templates/snippet/textinput.html')
  , textinputmulti           = require('text!templates/snippet/textinputmulti.html')
  , textinputmulti2          = require('text!templates/snippet/textinputmulti2.html')
  , multiselectbasic         = require('text!templates/snippet/multiselectbasic.html')
  , floatbutton              = require('text!templates/snippet/floatbutton.html')
  , textinputsingle          = require('text!templates/snippet/textinputsingle.html')
  , selectbasicsingle        = require('text!templates/snippet/selectbasicsingle.html')
  , textareasingle           = require('text!templates/snippet/textareasingle.html')
  , separator                = require('text!templates/snippet/separator.html')
  , valuebox                = require('text!templates/snippet/valuebox.html');

  return {
    formname                   : formname
    , prependedtext            : prependedtext
    , search                   : search
    , textinput                : textinput
    , appendedcheckbox         : appendedcheckbox
    , appendedtext             : appendedtext
    , filebutton               : filebutton
    , singlebutton             : button
    , doublebutton             : buttondouble
    , buttondropdown           : buttondropdown
    , multiplecheckboxes       : multiplecheckboxes
    , multiplecheckboxesinline : multiplecheckboxesinline
    , multipleradios           : multipleradios
    , multipleradiosinline     : multipleradiosinline
    , passwordinput            : passwordinput
    , prependedcheckbox        : prependedcheckbox
    , prependedtext            : prependedtext
    , searchinput              : searchinput
    , selectbasic              : selectbasic
    , selectmultiple           : selectmultiple
    , textarea                 : textarea
    , textinput                : textinput
    , textinputmulti           : textinputmulti
    , textinputmulti2          : textinputmulti2
    , multiselectbasic         : multiselectbasic
    , floatbutton              :floatbutton
    , textinputsingle          :textinputsingle
    , selectbasicsingle        :selectbasicsingle
    ,textareasingle            :textareasingle
    ,separator                 :separator
    ,valuebox                  :valuebox
  }
});
