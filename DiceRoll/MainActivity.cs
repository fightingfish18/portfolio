using System;

using Android.App;
using Android.Content;
using Android.Runtime;
using Android.Views;
using Android.Widget;
using Android.OS;
using System.Text;

namespace DiceRoll
{
	[Activity (Label = "DiceRoll", MainLauncher = true, Icon = "@drawable/icon")]
	public class MainActivity : Activity
	{
		protected override void OnCreate (Bundle bundle)
		{
			SetContentView (Resource.Layout.Main);
			base.OnCreate (bundle);

			Dice dice = new Dice();

			Button rollButton = FindViewById<Button> (Resource.Id.roll);
			ScrollView results = FindViewById<ScrollView> (Resource.Id.results);
			EditText sides = FindViewById<EditText> (Resource.Id.numSides);
			EditText rolls = FindViewById<EditText> (Resource.Id.numRolls);
			TextView done = new TextView (this);


			rollButton.Click += delegate
			{
				results.RemoveView(done);
				done.Text = "Results...";
				int size = 0;
				int number = 0;
				bool isNumericSides = int.TryParse(sides.Text, out size);
				bool isNumericRolls = int.TryParse(rolls.Text, out number);
				if (isNumericSides && isNumericRolls) {
					StringBuilder numbers = new StringBuilder();
					int[] result = dice.roll(size, number);
					int sum = 0;
					for (int i = 0; i < result.Length; i++) {
						sum += result[i];
						if (i < result.Length - 1) {
							numbers.Append(result[i] + " + ");
						} else {
							numbers.Append(result[i] + " = " + sum);
						}
					}
					done.Append("\n" + numbers.ToString());
				} else {
					done.Append("\n Please Enter Valid Numbers for the Number of Sides and Rolls.");
				}
				results.AddView(done);
			};
		}
	}
}


