export function trimStr(str: string, maxChars: number = 100): string {
  const strTr = str.trim();
  if (strTr.length <= maxChars) {
    return strTr;
  }

  return strTr.slice(0, maxChars - 3) + '...';
}
