<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="container">
    <h2>Modal Example</h2>

    <form>
        <h3>Select your favorite sports:</h3>
        <label><input type="checkbox" value="football" name="sport"> Football</label>
        <label><input type="checkbox" value="baseball" name="sport"> Baseball</label>
        <label><input type="checkbox" value="cricket" name="sport"> Cricket</label>
        <label><input type="checkbox" value="boxing" name="sport"> Boxing</label>
        <label><input type="checkbox" value="racing" name="sport"> Racing</label>
        <label><input type="checkbox" value="swimming" name="sport"> Swimming</label>
        <br><br>
    </form>

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <h3>Select your favorite sports:</h3>
                        <label><input type="checkbox" class="modal_check_box" value="football" name="sport"> Football</label>
                        <label><input type="checkbox" class="modal_check_box" value="baseball" name="sport"> Baseball</label>
                        <label><input type="checkbox" class="modal_check_box" value="cricket" name="sport"> Cricket</label>
                        <label><input type="checkbox" class="modal_check_box" value="boxing" name="sport"> Boxing</label>
                        <label><input type="checkbox" class="modal_check_box" value="racing" name="sport"> Racing</label>
                        <label><input type="checkbox" class="modal_check_box" value="swimming" name="sport"> Swimming</label>
                        <br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('.modal_check_box').change(function() {
            var test = $(this).val();
            if ($('input[value^=' + test + ']').prop('checked') == true) {
                $('input[value^=' + test + ']').prop('checked', false);
            } else {
                $('input[value^=' + test + ']').prop('checked', true);
            }
        });
    });
</script>