class Expense {
  final int? id;
  final String title;
  final String category;
  final double amount;
  final String paymentMethod;
  final String date;

  Expense({
    this.id,
    required this.title,
    required this.category,
    required this.amount,
    required this.paymentMethod,
    required this.date,
  });

  factory Expense.fromJson(Map<String, dynamic> json) {
    return Expense(
      id: json['id'],
      title: json['title'],
      category: json['category'],
      amount: double.parse(json['amount'].toString()),
      paymentMethod: json['payment_method'],
      date: json['date'],
    );
  }

  Map<String, dynamic> toJson() => {
    "title": title,
    "category": category,
    "amount": amount,
    "payment_method": paymentMethod,
    "date": date,
  };
}
