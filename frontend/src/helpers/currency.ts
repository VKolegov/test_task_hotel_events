const currencyFormatter = Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB' });

export function formatCurrency(val: number): string {
  return currencyFormatter.format(val);
}
