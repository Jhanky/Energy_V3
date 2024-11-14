 <!-- Modal planeacion y diseño-->
 <div class="modal fade" id="diseno-{{ $lista['pos'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <form action="">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">{{ $lista['name'] }}</h5>
                     <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">

                     @foreach ($lista['cards'] as $card)
                         <h6>{{ $card['name'] }}</h6>
                         @foreach ($card['checklists'] as $checklist)
                             <h6>{{ $checklist['name'] }}</h6>
                             @foreach ($checklist['checkItems'] as $checkItem)
                                 <div class="form-check">
                                     <input class="form-check-input" type="checkbox" id="check_{{ $checkItem['id'] }}"
                                         name="checkItems[{{ $checkItem['id'] }}]"
                                         {{ $checkItem['state'] === 'complete' ? 'checked' : '' }}>
                                     <label class="custom-control-label"
                                         for="check_{{ $checkItem['id'] }}">{{ $checkItem['name'] }}</label>
                                 </div>
                             @endforeach
                         @endforeach
                     @endforeach
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn bg-gradient-success" data-bs-dismiss="modal"
                         onclick="closeModal()">Guardar</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
