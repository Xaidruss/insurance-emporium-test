Application to calculate payment dates for following 12 months using the following rules
 - Staff are paid basic wages on last working day of each month where working days are monday - friday
 - Staff are paid bonuses on 10th of every month unless the 10th falls on a saturday or sunday where the bonus is paid on the first tuesday of that month

Specification
Inputs:
	Arguments:
	 - File Path (optional, default: laravel application directory)
		Command takes 1 optional argument for file location, this should accept either exact filepath or folder
		if path is folder, should output in folder destination with filename = output.csv
	Options:
	 - Length (default: 12)
	 	-L, --length
	 	This allows a user to change the number of months that are created by the command.
	 - Format (default "jS F Y")
	 	-F, --format
	 	This allows a user to change the date format of the Base & Bonus Pay Date Columns.
	 - Date (default: today)
	 	-D, --date
	 	This allows a user to change the date the command will calculate from, e.g.
	 		-D "01/01/2021" will calculate from 01/01/2021 to 12/01/2021

Output:
	The command will output a file at the File Path argument with the columns:
	 - Month
	 - Base Payment Date
     - Bonus Payment Date

To Run:
	To run this application navigate to the root "insurance-emporium-test" folder in bash or terminal and run the command: 
		"php artisan generate:pay-dates-csv"
	This will run the csv generator script. Options & Arguments can be given as described above to chaneg the content & formatting of the output csv.